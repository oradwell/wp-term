'use strict';

var wpTerm = function(termElem, url) {
    var self = {};
    self.termElem = termElem;
    self.url = url ? url : 'wp-term.php';

    self.historyCon = self.termElem.find('.term-history');
    self.promptText = self.termElem.find('.term-prompt').text();
    self.history = {
        list: [],
        cur: -1,
        tmp: ''
    };

    self.appendToHistory = function(string) {
        self.historyCon.append(string + '<br />');
        self.historyCon[0].scrollTop = self.historyCon[0].scrollHeight;
    };

    self.appendToHistoryArray = function(list) {
        for (var i = 0; i < list.length; i++) {
            self.appendToHistory(list[i]);
        }
    }

    self.appendCommand = function(string) {
        self.appendToHistory(self.promptText + ' ' + string);
    };

    self.executeCommand = function(command) {
        // Save the command if not empty string
        // and is different from last command
        if (command
            && self.history.list[self.history.list.length - 1] != command
        ) {
            self.history.list.push(command);
        }
        self.history.cur = self.history.list.length;
        self.history.tmp = '';
        self.appendCommand(command);
        switch (command.trim()) {
            case 'history':
                self.showHistory();
                break;
            case 'clear':
                self.clearHistoryCon();
                break;
            case 'exit':
                closeTerm();
                break;
            case '':
                break;
            default:
                self.sendRequest(command);
                break;
        }
    };

    self.sendRequest = function(command, callback) {
        if (typeof callback == 'undefined') {
            callback = self.handleResponse;
        }

        jQuery.get(self.url, {cmd: command}, callback);
    }

    self.showHistory = function() {
        self.appendToHistoryArray(self.history.list);
    }

    self.clearHistoryCon = function() {
        self.historyCon.html('');
    }

    self.handleResponse = function(response) {
        if (response.list && response.list.length) {
            self.appendToHistoryArray(response.list);
        } else if (response.msg) {
            self.appendToHistory(response.msg);
        } else if (response.url) {
            self.appendToHistory('Redirecting to: ' + response.url);
        }

        if (response.url) {
            var url = response.url;
            setTimeout(function() {
                document.location.href = url;
            }, 500);
        }
    };

    self.handleCompleteResponse = function(response, input) {
        if (response.complete) {
            // New cursor position: complete + blank space
            var newCurPos = input.selectionStart + response.complete.length + 1;
            // Beginning part
            input.value = input.value.substr(0, input.selectionStart)
                // complete + blank space
                + response.complete + ' '
                // ending part
                + input.value.substr(input.selectionEnd);

            // Move the cursor
            input.selectionStart = newCurPos;
            input.selectionEnd = newCurPos;
        } else if (response.list && response.list.length > 0) {
            // Remove complete from command before adding to list
            self.appendCommand(response.cmd.substr(9));
            // Show the list
            self.appendToHistoryArray(response.list);
        }
    };

    self.handleKeyDown = function(e) {
        var KEY_TAB = 9,
            inputElem = this;
        if (e.keyCode != KEY_TAB) {
            return;
        }

        self.sendRequest(
            'complete ' + inputElem.value.substr(0, inputElem.selectionStart),
            function(response) {
                self.handleCompleteResponse(response, inputElem);
            }
        );

        return false;
    };

    self.handleKeyUp = function(e) {
        var KEY_ENTER = 13,
            KEY_UPARR = 40,
            KEY_DNARR = 38;
        switch (e.keyCode) {
            case KEY_ENTER:
                self.executeCommand(this.value);
                this.value = '';
                break;
            case KEY_UPARR:
            case KEY_DNARR:
                var cur = self.history.cur,
                    prevCur = cur,
                    listLen = self.history.list.length;
                if (!listLen) {
                    break;
                }
                cur = e.keyCode == KEY_UPARR ? cur + 1 : cur - 1;
                // cur must be between 0 and listLen
                cur = Math.min(listLen, Math.max(cur, 0));

                if (cur == listLen) {
                    this.value = self.history.tmp;
                } else {
                    if (prevCur == listLen) {
                        self.history.tmp = this.value;
                    }
                    this.value = self.history.list[cur];
                }
                self.history.cur = cur;
                break;
        }

        return false;
    };

    return self;
};

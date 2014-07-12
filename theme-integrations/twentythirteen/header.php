<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
    <script type="text/javascript">
        'use strict';

        jQuery(function() {
            var wpTerm = (function(termElem) {
                var self = {
                    url: 'http://local-vm/secim/wp-posts-cli.php',
                    historyCon: termElem.find('.term-history'),
                    promptText: termElem.find('.term-prompt').text(),
                    history: {
                        list: [],
                        cur: -1,
                        tmp: ''
                    }
                };

                self.appendToHistory = function(string) {
                    self.historyCon.append(string + '<br />');
                    self.historyCon[0].scrollTop = self.historyCon[0].scrollHeight;
                };

                self.appendCommand = function(string) {
                    self.appendToHistory(self.promptText + ' ' + string);
                };

                self.appendResponse = function(response) {
                    if (response.list && response.list.length) {
                        for (var i = 0; i < response.list.length; i++) {
                            self.appendToHistory(response.list[i]);
                        }
                    } else if (response.msg) {
                        self.appendToHistory(response.msg);
                    } else if (response.url) {
                        self.appendToHistory('Redirecting to: ' + response.url);
                    }
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
                        case '':
                            break;
                        default:
                            self.sendRequest(command);
                            break;
                    }
                };

                self.sendRequest = function(command) {
                    jQuery.get(self.url, {cmd: command}, self.handleResponse);
                }

                self.showHistory = function() {
                    for (var i in self.history.list) {
                        self.appendToHistory(self.history.list[i]);
                    }
                }

                self.clearHistoryCon = function() {
                    self.historyCon.html('');
                }

                self.handleResponse = function(response) {
                    self.appendResponse(response);
                    if (response.url) {
                        var url = response.url;
                        setTimeout(function() {
                            document.location.href = url;
                        }, 500);
                    }
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
            }(jQuery('.terminal')));

            jQuery('.term-input').on('keyup', wpTerm.handleKeyUp);
        });
    </script>
	<style type="text/css">
		.terminal {
			font-family: "Courier New", Courier, monospace;
			color: #141412;
			min-height: 230px;
			width: 100%;
		}
		.term-history {
			height:190px; /* header height minus input height */
			overflow-y:auto;
		}
		.term-input {
			border: 0;
			width: calc(100% - 85px); /* subtract prompt width */
			overflow-x: hidden;
			font-family: inherit;
			font-size: inherit;
		}
	</style>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header" role="banner">
		<!-- 	<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</a> -->
			<div class="terminal">
				<div class="term-history"></div>
				<div class="term-cmd-line">
					<span class="term-prompt">prompt&gt;</span>
					<input class="term-input" value="" />
				</div>
			</div>
			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
					<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					<?php get_search_form(); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</header><!-- #masthead -->

		<div id="main" class="site-main">

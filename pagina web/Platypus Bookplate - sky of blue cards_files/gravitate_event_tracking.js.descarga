jQuery(function($)
{

	var GETGA_scroll_depths = ['25','50','75','100'];
	GETGA_scroll_depths['25'] = [];
	GETGA_scroll_depths['50'] = [];
	GETGA_scroll_depths['75'] = [];
	GETGA_scroll_depths['100'] = [];

	var GETGA_has_scrolled = [];
	var GETGA_has_resized = [];

	function getga_debug(msg)
	{
		if(typeof GETGA_settings['debug'] !== 'undefined')
		{
			if(GETGA_settings['debug'] === 'alert')
			{
				alert(msg);
			}
			else if(GETGA_settings['debug'] === 'console')
			{
				console.log(msg);
			}
		}
	}

	function getga_add_event_tracking(getga_event)
	{
		if(typeof getga_event['selector'] !== 'undefined')
		{
			if(getga_event['selector'] === 'window')
			{
				getga_event['selector'] = window;
			}

			if(getga_event['selector'] === 'document')
			{
				getga_event['selector'] = document;
			}

			$(getga_event['selector']).on(getga_event['action_type'].replace('depth', ''), function(e){

				var scrolled_perc = 0;

				var label = getga_event['label'];

				var labelKey = getga_event['selector']+'_'+getga_event['action_type']+'_'+label;

				if(getga_event['action_type'] === 'resize')
				{
					if($.inArray(labelKey, GETGA_has_resized) > -1)
					{
						return false;
					}
					GETGA_has_resized.push(labelKey);
				}
				else if(getga_event['action_type'] === 'scroll')
				{
					if($.inArray(labelKey, GETGA_has_scrolled) > -1)
					{
						return false;
					}
					GETGA_has_scrolled.push(labelKey);
				}
				else if(getga_event['action_type'] === 'scrolldepth')
				{
					var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();
					scrolled_perc = ((wintop/(docheight-winheight))*100);

					if(scrolled_perc < 25)
					{
						return false;
					}

					if(scrolled_perc >= 25 && scrolled_perc < 50)
					{
						if($.inArray(labelKey, GETGA_scroll_depths['25']) > -1)
						{
							return false;
						}
						GETGA_scroll_depths['25'].push(labelKey);
						scrolled_perc = 25;
					}

					if(scrolled_perc >= 50 && scrolled_perc < 75)
					{
						if($.inArray(labelKey, GETGA_scroll_depths['50']) > -1)
						{
							return false;
						}
						GETGA_scroll_depths['50'].push(labelKey);
						scrolled_perc = 50;
					}

					if(scrolled_perc >= 75 && scrolled_perc < 99)
					{
						if($.inArray(labelKey, GETGA_scroll_depths['75']) > -1)
						{
							return false;
						}
						GETGA_scroll_depths['75'].push(labelKey);
						scrolled_perc = 75;
					}

					if(scrolled_perc >= 99)
					{
						if($.inArray(labelKey, GETGA_scroll_depths['100']) > -1)
						{
							return false;
						}
						GETGA_scroll_depths['100'].push(labelKey);
						scrolled_perc = 100;
					}
				}

				var NA = 'undefined';

				getga_debug('GETGA: Selector '+getga_event['action_type']+' ('+getga_event['selector']+')');

				if(label.indexOf("{ITEM_TITLE}") > -1)
				{
					label = label.replace("{ITEM_TITLE}", ($(this).attr('title') !== undefined ? $(this).attr('title') : NA));
				}
				if(label.indexOf("{PAGE_URL}") > -1)
				{
					label = label.replace("{PAGE_URL}", location.href);
				}
				if(label.indexOf("{PAGE_RELATIVE_URL}") > -1)
				{
					label = label.replace("{PAGE_RELATIVE_URL}", location.pathname);
				}
				if(label.indexOf("{LINK_URL}") > -1)
				{
					label = label.replace("{LINK_URL}", ($(this).attr('href') !== undefined ? $(this).attr('href') : NA));
				}
				if(label.indexOf("{LINK_RELATIVE_URL}") > -1)
				{
					label = label.replace("{LINK_RELATIVE_URL}", ($(this).attr('href') !== undefined ? $(this).attr('href').replace(/^(?:\/\/|[^\/]+)*\//, '/') : NA));
				}
				if(label.indexOf("{IMAGE_SRC}") > -1)
				{
					label = label.replace("{IMAGE_SRC}", ($(this).attr('src') !== undefined ? $(this).attr('src') : NA));
				}
				if(label.indexOf("{IMAGE_ALT}") > -1)
				{
					label = label.replace("{IMAGE_ALT}", ($(this).attr('alt') !== undefined ? $(this).attr('alt') : NA));
				}
				if(label.indexOf("{TAG_HTML}") > -1)
				{
					label = label.replace("{TAG_HTML}", $(this).html().replace(/(<([^>]+)>)/ig,'').replace(/(\r\n|\n|\r)/gm,'').replace(/\s{2,}/g, ' '));
				}
				if(label.indexOf("{SCROLL_PERCENTAGE}") > -1)
				{
					label = label.replace("{SCROLL_PERCENTAGE}", scrolled_perc);
				}

				if(typeof ga === 'undefined' && typeof __gaTracker !== 'undefined')
				{
					try
					{
						__gaTracker('send', 'event', getga_event['category'], getga_event['action_label'], label);
						getga_debug("GETGA: Sent to Universal Tracking [ __gaTracker('send', 'event', '"+getga_event['category']+"', '"+getga_event['action_label']+"', '"+label+"'); ]");
					}
					catch(err)
					{
						getga_debug('GETGA: [ERROR] Sending to Universal Tracking via __gaTracker ('+err+')');
					}
				}
				else if(typeof ga !== 'undefined')
				{
					try
					{
						// Update to work with GTM
						var getga_tracker = ga.getAll()[0];
						if(typeof getga_tracker !== 'undefined' && getga_tracker)
						{
							getga_tracker.send('event', getga_event['category'], getga_event['action_label'], label);
							getga_debug("GETGA: Sent to Universal Tracking [ getga_tracker.send('event', '"+getga_event['category']+"', '"+getga_event['action_label']+"', '"+label+"'); ]");
						}
						else
						{
							ga('send', 'event', getga_event['category'], getga_event['action_label'], label);
							getga_debug("GETGA: Sent to Universal Tracking [ ga('send', 'event', '"+getga_event['category']+"', '"+getga_event['action_label']+"', '"+label+"'); ]");
						}
					}
					catch(err)
					{
						getga_debug('GETGA: [ERROR] Sending to Universal Tracking via ga ('+err+')');
					}
				}
				else if(typeof _gaq !== 'undefined')
				{
					try
					{
						_gaq.push(['_trackEvent', getga_event['category'], getga_event['action_label'], label]);
						getga_debug("GETGA: Sent to Standard Tracking [ _gaq.push(['_trackEvent', '"+getga_event['category']+"', '"+getga_event['action_label']+"', '"+label+"']); ]");
					}
					catch(err)
					{
						getga_debug('GETGA: [ERROR] Sending to Standard Tracking ('+err+')');
					}

				}
				else
				{
					getga_debug('GETGA: [ERROR] Google Analytics not found (Missing all _gaq, ga, and __gaTracker)');
				}
			});
		}
	}

	function getga_add_external_class(host)
	{
		$('a').each(function() {
			if ((!host.test(this.href) && this.href.slice(0, 1) != "/" && this.href.slice(0, 1) != "#" && this.href.slice(0, 1) != "?" && this.href.slice(0, 10) != "javascript")) {
				$(this).addClass('gtrackexternal');
			}
	    });
	}

	function getga_has_ga()
	{
		if (typeof _gaq !== 'undefined' || typeof ga !== 'undefined' || typeof __gaTracker !== 'undefined') // Check if Google Analytics is Loaded
		{
			return true;
		}

		return false;
	}

	function getga_load_event_tracking()
	{
		if(typeof jQuery !== 'undefined') // Check if jQuery is Loaded
		{
			getga_debug('GETGA: Found jQuery.');

			if(getga_has_ga()) // Check if Google Analytics is Loaded
			{
				getga_debug('GETGA: Found Google Analytics');
				getga_add_all_event_tracking();
			}
			else
			{
				getga_debug('GETGA: [ERROR] Missing Google Analytics. Trying Again...');

				setTimeout(function()
				{
					if(getga_has_ga()) // Check if Google Analytics is Loaded
					{
						getga_debug('GETGA: Found Google Analytics');
						getga_add_all_event_tracking();
					}
					else
					{
						setTimeout(function()
						{
							if(getga_has_ga()) // Check if Google Analytics is Loaded
							{
								getga_debug('GETGA: Found Google Analytics after First Delay');
								getga_add_all_event_tracking();
							}
							else
							{
								getga_debug('GETGA: [ERROR] Still Missing Google Analytics. Trying Again...');

								setTimeout(function()
								{
									if(getga_has_ga()) // Check if Google Analytics is Loaded
									{
										getga_debug('GETGA: Found Google Analytics after Second Delay');
										getga_add_all_event_tracking();
									}
									else
									{
										getga_debug('GETGA: [ERROR] Still Missing Google Analytics. Please review that you have loaded Google Analytics Properly.');
									}


								}, (GETGA_settings['second_delay']*1000));
							}

						}, (GETGA_settings['first_delay']*1000));
					}

				}, 500);
			}
		}
		else
		{
			getga_debug('GETGA: [ERROR] Missing jQuery.');
		}
	}

	function getga_add_all_event_tracking()
	{
		var evt,
			txt,
			selector,
			loadedKey,
			loaded = [],
			host = new RegExp('/' + window.location.host + '/');

		if(typeof GETGA_events !== 'undefined')
		{
			for(evt in GETGA_events)
			{
				txt = document.createElement("textarea");
			    txt.innerHTML = GETGA_events[evt]['selector'];
				selector = txt.value.replace(/\\/g, '');

				GETGA_events[evt]['selector'] = selector;

				loadedKey = selector+'_'+GETGA_events[evt]['action_type']+'_'+GETGA_events[evt]['label'];

				if($.inArray(loadedKey, loaded) < 0)
				{
					loaded.push(loadedKey);

					if(typeof GETGA_events[evt]['status'] !== 'undefined' && typeof selector !== 'undefined')
					{
						if(GETGA_events[evt]['status'] === 'active')
						{
							if(selector === '.gtrackexternal')
							{
								getga_add_external_class(host);
							}

							if(selector === 'window')
							{
								selector = window;
							}

							if(selector === 'document')
							{
								selector = document;
							}

							if($(selector).length)
							{
								getga_add_event_tracking(GETGA_events[evt]);
								getga_debug('GETGA: Found selector ('+selector+')');
							}
							else if(GETGA_settings['first_delay'])
							{
								setTimeout(function(GETGA_event, selector)
								{
									if(selector === '.gtrackexternal')
									{
										getga_add_external_class(host);
									}

									if($(selector).length)
									{
										getga_add_event_tracking(GETGA_event);
										getga_debug('GETGA: Found Selector after First Delay ('+selector+')');
									}
									else if(GETGA_settings['second_delay'])
									{
										setTimeout(function(GETGA_event, selector)
										{
											if(selector === '.gtrackexternal')
											{
												getga_add_external_class(host);
											}

											if(!$(selector).length)
											{
												getga_debug('GETGA: Still could NOT find selector ('+selector+') Will try and add the listener anyways.');
											}
											getga_add_event_tracking(GETGA_event);

										}, (GETGA_settings['second_delay']*1000), GETGA_event, selector);

										getga_debug('GETGA: Did NOT find selector ('+selector+') Will check again in '+GETGA_settings['second_delay']+' seconds.');
									}

								}, (GETGA_settings['first_delay']*1000), GETGA_events[evt], selector);

								getga_debug('GETGA: Did NOT find selector ('+selector+') Will check again in '+GETGA_settings['first_delay']+' seconds.');
							}
						}
					}
				}
			}
		}
	}

	getga_load_event_tracking();

});

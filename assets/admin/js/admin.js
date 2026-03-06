/* global SKModalAdmin */

(function ($) {
    'use strict';

    console.log('SK Modal Builder Admin JS Loaded');

    const SKMB = {
        init() {
            this.initColorPicker();
            this.initTriggers();
            this.initTabs();
            this.initPageSelector();
        },

        initColorPicker() {
            $('.sk-color-field').each(function () {
                const $input = $(this);

                // Avoid re-initializing already initialized pickers
                if (!$input.hasClass('wp-color-picker')) {
                    $input.wpColorPicker({
                        // Optional: customize palettes, change button text, etc.
                        // palettes: ['#000', '#fff', '#f00'],
                        change: function () {
                            // Optional: trigger save or preview update
                        },
                        clear: function () {
                            // Optional: handle clear button
                        }
                    });
                }
            });
        },

        initTriggers() {
            const $triggerSelect = $('#sk-modal-trigger');

            const toggleSections = () => {
                $('.sk-trigger').hide();

                const triggerType = $triggerSelect.val();
                if (triggerType) {
                    $(`.sk-${triggerType}`).fadeIn(150);
                }
            };

            // Run on load + listen for changes
            toggleSections();
            $triggerSelect.on('change', toggleSections);
        },

        initTabs() {
            const $tabs   = $('[data-skmb-tab]');
            const $panels = $('.skmb-tab-panel');

            if (!$tabs.length) {
                return;
            }

            const activateTab = ($tab) => {
                const target = $tab.data('skmb-tab');

                $tabs.removeClass('active');
                $tab.addClass('active');

                $panels.hide();
                $(`#${target}`).fadeIn(150);
            };

            // Activate first tab on load
            activateTab($tabs.first());

            // Click handler
            $tabs.on('click', function (e) {
                e.preventDefault();
                activateTab($(this));
            });
        },

        initPageSelector() {
            const $select        = $('#sk-modal-pages-select');
            const $specificBlocks = $('.sk-specific');

            const toggleVisibility = () => {
                if ($select.val() === 'specific') {
                    $specificBlocks.slideDown(180);
                } else {
                    $specificBlocks.slideUp(180);
                }
            };

            $select.on('change', toggleVisibility);
            toggleVisibility(); // initial state
        }
    };

    // Run initialization after DOM is ready
    $(() => {
        SKMB.init();
    });

})(jQuery);
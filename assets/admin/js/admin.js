/* global SKModalAdmin */

console.log('SK Modal Builder Admin JS Loaded');

jQuery(function ($) {

    const SKMB = {

        init() {
            this.initColorPicker();
            this.initTriggers();
            this.initTabs();
            this.initPageSelector();
        },

        initColorPicker() {
            if ($.fn.wpColorPicker) {
                $('.sk-color-field').wpColorPicker();
            }
        },

        initTriggers() {
            const toggle = () => {

                $('.sk-trigger').hide();

                const trigger = $('#sk-modal-trigger').val();
                if (!trigger) return;

                $('.sk-' + trigger).show();
            };

            toggle();
            $(document).on('change', '#sk-modal-trigger', toggle);
        },

        initTabs() {
            const $tabs = $('[data-skmb-tab]');
            const $panels = $('.skmb-tab-panel');

            if (!$tabs.length) return;

            $tabs.on('click', function (e) {
                e.preventDefault();

                const target = $(this).data('skmb-tab');

                $tabs.removeClass('active');
                $(this).addClass('active');

                $panels.hide();
                $('#' + target).fadeIn(150);
            });

            $tabs.first().trigger('click');
        },

        initPageSelector() {
            const $select = $('#sk-modal-pages-select');
            const $pages = $('#sk-modal-specific-pages');
            const $front = $('#sk-modal-front-page-wrapper');

            const togglePages = () => {
                if ($select.val() === 'specific') {
                    $pages.slideDown(150);
                    $front.slideDown(150);
                } else {
                    $pages.slideUp(150);
                    $front.slideUp(150);
                }
            };

            $select.on('change', togglePages);
            togglePages();
        }
    };

    SKMB.init();

});

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SKMB_Builder_UI {

    public static function render() {
        ?>
        <div class="skmb-builder">
            <div class="skmb-sidebar">
                <button data-skmb-tab="skmb-design">Design</button>
                <button data-skmb-tab="skmb-trigger">Triggers</button>
                <button data-skmb-tab="skmb-rules">Conditions</button>
            </div>

            <div class="skmb-content">
                <div id="skmb-design" class="skmb-tab-panel">
                    <div class="skmb-field">
                        <label>Modal Content</label>
                        <?php wp_editor('', 'skmb_content'); ?>
                    </div>
                </div>

                <div id="skmb-trigger" class="skmb-tab-panel" style="display:none">
                    <div class="skmb-field">
                        <label>Delay (seconds)</label>
                        <input type="number" name="skmb_delay" />
                    </div>
                    <div class="skmb-field">
                        <label>Scroll %</label>
                        <input type="number" name="skmb_scroll" />
                    </div>
                </div>

                <div id="skmb-rules" class="skmb-tab-panel" style="display:none">
                    <label>
                        <input type="checkbox" name="skmb_logged_in" />
                        Show only for logged-in users
                    </label>
                </div>
            </div>
        </div>
        <?php
    }
}

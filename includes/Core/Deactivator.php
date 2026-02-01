<?php

class SK_Modal_Deactivator {
    public static function deactivate() {
        flush_rewrite_rules();
    }
}

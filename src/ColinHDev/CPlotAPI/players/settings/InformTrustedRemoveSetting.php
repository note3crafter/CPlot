<?php

namespace ColinHDev\CPlotAPI\players\settings;

use ColinHDev\CPlotAPI\attributes\BooleanAttribute;

/**
 * @extends BooleanAttribute<InformTrustedRemoveSetting, bool>
 */
class InformTrustedRemoveSetting extends BooleanAttribute implements Setting {

    protected static string $ID = self::SETTING_INFORM_TRUSTED_REMOVE;
    protected static string $permission = self::PERMISSION_BASE . self::SETTING_INFORM_TRUSTED_REMOVE;
    protected static string $default;
}
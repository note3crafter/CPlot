<?php

namespace ColinHDev\CPlotAPI\players\settings;

use ColinHDev\CPlotAPI\attributes\BooleanListAttribute;

/**
 * @extends BooleanListAttribute<WarnItemDropFlagSetting, bool>
 */
class WarnItemDropFlagSetting extends BooleanListAttribute implements Setting {

    protected static string $ID = self::SETTING_WARN_FLAG_ITEM_DROP;
    protected static string $permission = self::PERMISSION_BASE . self::SETTING_WARN_FLAG_ITEM_DROP;
    protected static string $default;
}
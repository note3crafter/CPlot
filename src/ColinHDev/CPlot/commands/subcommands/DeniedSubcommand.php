<?php

declare(strict_types=1);

namespace ColinHDev\CPlot\commands\subcommands;

use ColinHDev\CPlot\commands\Subcommand;
use ColinHDev\CPlot\player\PlayerData;
use ColinHDev\CPlot\plots\Plot;
use ColinHDev\CPlot\provider\DataProvider;
use ColinHDev\CPlot\provider\LanguageManager;
use ColinHDev\CPlot\worlds\WorldSettings;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

/**
 * @phpstan-extends Subcommand<null>
 */
class DeniedSubcommand extends Subcommand {

    public function execute(CommandSender $sender, array $args) : \Generator {
        if (!$sender instanceof Player) {
            yield LanguageManager::getInstance()->getProvider()->awaitMessageSendage($sender, ["prefix", "denied.senderNotOnline"]);
            return null;
        }

        if (!((yield DataProvider::getInstance()->awaitWorld($sender->getWorld()->getFolderName())) instanceof WorldSettings)) {
            yield LanguageManager::getInstance()->getProvider()->awaitMessageSendage($sender, ["prefix", "denied.noPlotWorld"]);
            return null;
        }
        $plot = yield Plot::awaitFromPosition($sender->getPosition());
        if (!($plot instanceof Plot)) {
            yield LanguageManager::getInstance()->getProvider()->awaitMessageSendage($sender, ["prefix", "denied.noPlot"]);
            return null;
        }

        $deniedPlayerData = [];
        foreach ($plot->getPlotDenied() as $plotPlayer) {
            $playerData = yield DataProvider::getInstance()->awaitPlayerDataByUUID($plotPlayer->getPlayerUUID());
            if ($playerData instanceof PlayerData) {
                $playerName = $playerData->getPlayerName();
            } else {
                $playerName = "ERROR";
            }
            /** @phpstan-var string $addTime */
            $addTime = yield LanguageManager::getInstance()->getProvider()->awaitTranslationForCommandSender(
                $sender,
                ["denied.success.list.addTime.format" => explode(".", date("d.m.Y.H.i.s", (int) (round($plotPlayer->getAddTime() / 1000))))]
            );
            $deniedPlayerData[] = yield LanguageManager::getInstance()->getProvider()->awaitTranslationForCommandSender(
                $sender,
                ["denied.success.list" => [
                    $playerName,
                    $addTime
                ]]
            );
        }
        if (count($deniedPlayerData) === 0) {
            yield LanguageManager::getInstance()->getProvider()->awaitMessageSendage($sender, ["prefix", "denied.noDeniedPlayers"]);
            return null;
        }

        /** @phpstan-var string $separator */
        $separator = yield LanguageManager::getInstance()->getProvider()->awaitTranslationForCommandSender($sender, "denied.success.list.separator");
        $list = implode($separator, $deniedPlayerData);
        yield LanguageManager::getInstance()->getProvider()->awaitMessageSendage(
            $sender,
            [
                "prefix",
                "denied.success" => $list
            ]
        );
        return null;
    }
}
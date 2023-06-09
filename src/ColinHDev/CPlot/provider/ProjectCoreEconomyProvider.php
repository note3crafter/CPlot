<?php

namespace ColinHDev\CPlot\provider;

use ColinHDev\CPlot\ResourceManager;
use pocketmine\player\Player;
use pocketmine\Server;
use TheNote\core\BaseAPI;

class ProjectCoreEconomyProvider extends EconomyProvider
{
    public function __construct()
    {
        if (Server::getInstance()->getPluginManager()->getPlugin("CoreV7") === null) {
            throw new \RuntimeException("ProjectCore requires the plugin \"CoreV7\" to be installed.");
        }
    }

    public function removeMoney(Player $player, float $money, string $reason, callable $onSuccess, callable $onError): void
    {
        $api = new BaseAPI();
        $currency = ResourceManager::getInstance()->getConfig()->get("projectcore", "money");

        if($currency === "money") {
            $api->removeMoney($player, $money);
        } elseif ($currency === "coins") {
            $api->removeCoins($player, $money);
        }
    }

    public function parseMoneyToString(float $money) : string {
        return (string) floor($money);
    }

    public function getCurrency(): string
    {
        return;
    }
}
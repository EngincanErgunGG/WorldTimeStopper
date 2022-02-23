<?php

namespace EngincanErgunGG;

use pocketmine\{
    plugin\PluginBase,
    event\Listener,
    event\player\PlayerJoinEvent,
    event\entity\EntityLevelChangeEvent, 
    Server
};

class TimeStopper extends PluginBase implements Listener {

    function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents(new class($this) implements Listener {
            function onJoin(PlayerJoinEvent $event): void {
                $level = $event->getPlayer()->getLevel();
                $level->setTime(0);
                $level->stopTime();
            }
            
            function onLevelChange(EntityLevelChangeEvent $event): void {
                if (!Server::getInstance()->isLevelLoaded($event->getTarget()->getFolderName())){
                    Server::getInstance()->loadLevel($event->getTarget()->getFolderName());
                }
                $event->getTarget()->setTime(0);
                $event->getTarget()->stopTime();
            }
        }, $this);
        $this->getLogger()->info("Eklenti aktif edildi.");
    }
}

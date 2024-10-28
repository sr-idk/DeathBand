<?php

namespace Ghost;

use Ghost\Manager\LivesManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Ghost\commands\LivesCommand;
use Ghost\commands\LiveCommand;
use Ghost\Npcs\Kit;
use Ghost\Npcs\Modality;
class Loader extends PluginBase
{
    use SingletonTrait;
    private $LivesManager;

    protected function onLoad(): void{self::setInstance($this);}
    protected function onEnable(): void
    {
        $this->LivesManager = new LivesManager();
        $this->getLogger()->info("Deatband is Enable");
        $this->getServer()->getPluginManager()->registerEvents(new Events(), $this);
        $this->registerSubCommand(new LivesCommand($this));
        $this->registerSubCommand(new LiveCommand($this));
        $this->saveDefaultConfig();
        EntityFactory::getInstance()->register(Kit::class, function (World $world, CompoundTag $nbt): Kit {
        	return new Kit(EntityDataHelper::parseLocation($nbt, $world), Kit::parseSkinNBT($nbt), $nbt);
        }, ['Kit']);


        EntityFactory::getInstance()->register(Modality::class, function (World $world, CompoundTag $nbt): Modality {
            return new Modality(EntityDataHelper::parseLocation($nbt, $world), Modality::parseSkinNBT($nbt), $nbt);
        }, ['Modality']);
    }

    public function getLivesManager(): LivesManager
    {
        return $this->LivesManager;
    }
}
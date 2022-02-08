<?php

declare(strict_types = 1);

namespace JavierLeon9966\Lifesteal;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

final class Main extends PluginBase implements Listener{

	public function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @priority MONITOR
	 */
	public function onPlayerDeath(PlayerDeathEvent $event): void{
		$player = $event->getPlayer();
		$player->setMaxHealth($player->getMaxHealth() - 1);
		
		$lastDamageCause = $player->getLastDamageCause();
		if($lastDamageCause instanceof EntityDamageByEntityEvent){
			$entity = $lastDamageCause->getEntity();
			if($entity instanceof Player){
				$entity->setMaxHealth($entity->getMaxHealth() + 1);
			}
		}
		if($player->getMaxHealth() === 0){
			if($player->kick('You lost all your healths')){
				$player->getServer()->getNameBans()->addBan($player->getName(), 'Lost all healths');
			}
		}
	}
}

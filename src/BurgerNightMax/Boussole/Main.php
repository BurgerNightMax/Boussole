<?php

namespace BurgerNightMax\Boussole;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener
{

public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function onJoin(PlayerJoinEvent $event){
           $player = $event->getPlayer();

           $slot5 = Item::get(345, 0, 1);

           $slot2 = Item::get(421, 0, 1);
     $slot5->setCustomName("§clist-serveur");
          
$slot2->setCustomName("§a/nick");
           $player->getInventory()->ClearAll();
           $player->getInventory()->setItem(0, $slot5);

$player->getInventory()->setItem(0, $slot2);
    }

    public function onInteract(PlayerInteractEvent $event){
           $player = $event->getPlayer();
           $item = $event->getItem();

           if($item->getId() == 345){
              $event->setCancelled();
              $this->serveurlist($player);
              return true;
           }

           if($item->getId() == 421){
              $event->setCancelled();
              $cmd = "nick on";
              return true;
           }
    }

	public function serveurlist(Player $sender){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createSimpleForm(function (Player $sender, ?int $data = null){
		$result = $data;
		if($result === null){
			return;
		    }
			switch($result){
				case 0:
				$cmd = "transferserver RubydiumFaction.mcpe.eu 19595 on";
				$this->getServer()->getCommandMap()->dispatch($sender, $cmd);
				break;
				case 1:
				$cmd = "transferserver RubydiumFaction2.mcpe.eu 19320 on";
				$this->getServer()->getCommandMap()->dispatch($sender, $cmd);
				break;
				case 2:
				$cmd = "transferserver RubydiumMinage.mcpe.eu 19134 on";
				
				$this->getServer()->getCommandMap()->dispatch($sender, $cmd);
				break;
				
			}
		});
		$form->setTitle("§l§6Liste Des Serveurs");
		$form->setContent("§l§aChoisi ton serveur !");
		$form->addButton("§e Faction 1", 0, "textures/items/gold_sword.png");
		$form->addButton("§3 Faction 2", 0, "textures/items/diamond_sword.png");
  $form->addButton("§d Minage", 0, "textures/items/gold_pickaxe.png");
		$form->sendToPlayer($sender);
			return $form;
	} 
} 

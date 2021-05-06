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
use pocketmine\utils\Config;
	
class Main extends PluginBase implements Listener
{

public $cfg;	
	
public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
	@mkdir($this->getDataFolder());
        $this->cfg = $this->getConfig();
        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $event){
           $player = $event->getPlayer();

           $slot5= Item::get(345, 0, 1);

     $slot5->setCustomName("$this->cfg->get("nom")");
          
           $player->getInventory()->ClearAll();
           $player->getInventory()->setItem(0, $slot5);
    }

    public function onInteract(PlayerInteractEvent $event){
           $player = $event->getPlayer();
           $item = $event->getItem();

           if($item->getId() == 345){
              $event->setCancelled();
              $this->serveurlist($player);
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
				$cmd = "transferserver $this->cfg->get("ip1") $this->cfg->get("port1") on";
				$this->getServer()->getCommandMap()->dispatch($sender, $cmd);
				break;
				case 1:
				$cmd = "transferserver $this->cfg->get("ip2") $this->cfg->get("port2") on";
				$this->getServer()->getCommandMap()->dispatch($sender, $cmd);
				break;
				case 2:
				$cmd = "transferserver $this->cfg->get("ip3") $this->cfg->get("port3") on";
				
				$this->getServer()->getCommandMap()->dispatch($sender, $cmd);
				break;
				
			}
		});
		$form->setTitle("$this->cfg->get("titre")");
		$form->setContent("$this->cfg->get("content")");
		$form->addButton("$this->cfg->get("button1")", 0, "textures/items/gold_sword.png");
		$form->addButton("$this->cfg->get("button2")", 0, "textures/items/diamond_sword.png");
                $form->addButton("$this->cfg->get("button3")", 0, "textures/items/gold_pickaxe.png");
		$form->sendToPlayer($sender);
			return $form;
	} 
}

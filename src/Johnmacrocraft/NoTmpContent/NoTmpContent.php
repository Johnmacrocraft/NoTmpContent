<?php

namespace Johnmacrocraft\NoTmpContent;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoTmpContent extends PluginBase {

	public function onDisable() {
		if(file_exists($this->getServer()->getDataPath() . "tmp")) {
			$this->getLogger()->notice(TextFormat::GOLD . "Cleaning tmp folder...");
			$this->rmdirAll($this->getServer()->getDataPath() . "tmp");
			$this->getLogger()->notice(TextFormat::GREEN . "Done!");
		} else {
			$this->getLogger()->notice(TextFormat::RED . "NoTmpContent didn't clear tmp folder because it doesn't exist. Seems like you're not using PocketMine-MP for Android or deleted it yourself?");
		}
	}

	public function rmdirAll($dir) {
		$dirs = dir($dir);
		while(false !== ($entry = $dirs->read())) {
			if(($entry != ".") && ($entry != "..")) {
				if(is_dir($dir . "/" . $entry)) {
					$this->rmdirAll($dir . "/" . $entry);
					@rmdir($dir . "/" . $entry);
				} else {
					@unlink($dir . "/" . $entry);
				}
			}
		}
	$dirs->close();
	}
}
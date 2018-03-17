<?php

namespace Johnmacrocraft\NoTmpContent;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoTmpContent extends PluginBase {

	public function onDisable() {
		if(file_exists($this->getServer()->getDataPath() . "tmp")) {
			$this->getLogger()->info(TextFormat::GOLD . "Cleaning tmp folder...");
			$this->rmdirAll($this->getServer()->getDataPath() . "tmp");
			$this->getLogger()->info(TextFormat::GREEN . "Done!");
		} else {
			$this->getLogger()->info(TextFormat::RED . "NoTmpContent didn't clear tmp folder because it doesn't exist. Seems like you're not using PocketMine-MP for Android or deleted it yourself?");
		}
	}

	/*
	 * @param string $dir
	 */
	public function rmdirAll(string $dir) : void {
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
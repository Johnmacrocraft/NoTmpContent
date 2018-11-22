<?php

/*
 *
 * NoTmpContent
 *
 * Copyright © 2017-2018 Johnmacrocraft
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

namespace Johnmacrocraft\NoTmpContent;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoTmpContent extends PluginBase {

	public function onDisable() : void {
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
	private function rmdirAll(string $dir) : void {
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

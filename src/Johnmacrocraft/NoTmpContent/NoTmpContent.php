<?php

/*
 *
 * NoTmpContent
 *
 * Copyright (C) 2017-2021 Johnmacro
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace Johnmacrocraft\NoTmpContent;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoTmpContent extends PluginBase {

	public function onDisable() : void {
		if(file_exists($this->getServer()->getDataPath() . "tmp")) {
			$this->getLogger()->info(TextFormat::GOLD . "Cleaning the tmp folder...");

			$rmdirAll = function(string $dir) use(&$rmdirAll) {
				$dirs = dir($dir);
				while(false !== ($entry = $dirs->read())) {
					if(($entry != ".") && ($entry != "..")) {
						if(is_dir($dir . "/" . $entry)) {
							$rmdirAll($dir . "/" . $entry);
							@rmdir($dir . "/" . $entry);
						} else {
							@unlink($dir . "/" . $entry);
						}
					}
				}
				$dirs->close();
			};
			$rmdirAll($this->getServer()->getDataPath() . "tmp");

			$this->getLogger()->info(TextFormat::GREEN . "Done!");
		} else {
			$this->getLogger()->info(TextFormat::RED . "NoTmpContent did not clear the tmp folder because it does not exist.");
		}
	}
}

<?php
define("ROOT",realpath(__dir__.""));

require_once(ROOT."/kernel/Kernel.php");
Kernel::run();
?>
<?php

namespace Xielei\Swoole\Cmd;

use Swoole\Coroutine\Server\Connection;
use Xielei\Swoole\CmdInterface;
use Xielei\Swoole\Gateway;

class CloseClient implements CmdInterface
{
    public static function getCommandCode(): int
    {
        return 2;
    }

    public static function encode(int $fd, bool $force = false): string
    {
        return pack('CNC', SELF::getCommandCode(), $fd, $force);
    }

    public static function decode(string $buffer): array
    {
        return unpack('Nfd/Cforce', $buffer);
    }

    public static function execute(Gateway $gateway, Connection $conn, string $buffer): bool
    {
        $data = self::decode($buffer);
        $gateway->close($data['fd'], $data['force']);
        return true;
    }
}

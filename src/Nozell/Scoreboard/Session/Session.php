<?php

namespace Nozell\Scoreboard\Session;

class Session
{
    private string $xuid;
    private string $scoreboard = 'default';

    public function __construct(string $xuid)
    {
        $this->xuid = $xuid;
    }

    public function getXuid(): string
    {
        return $this->xuid;
    }

    public function setScoreboard(string $scoreboardName): void
    {
        $this->scoreboard = $scoreboardName;
    }

    public function getScoreboard(): string
    {
        return $this->scoreboard;
    }
}

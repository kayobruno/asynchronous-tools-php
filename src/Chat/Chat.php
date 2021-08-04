<?php

declare(strict_types=1);

namespace App\Chat;

use SplObjectStorage;

final class Chat
{
    private $members;

    public function __construct()
    {
        $this->members = new SplObjectStorage();
    }

    public function addMember(Member $member) : void
    {
        $this->members->attach($member);

        $this->newMessageTo("Bem-vindo(a), {$member->getName()}", $member);
        $this->newMessageToAll("{$member->getName()} entrou na sala;", $member);

        $member->onData(function ($data) use ($member) {
            $this->newMessage("{$member->getName()} diz: {$data}", $member);
        });

        $member->onClose(function () use ($member) {
            $this->members->detach($member);
            $this->newMessage("{$member->getName()} saiu da sala.", $member);
        });
    }

    private function newMessage(string $message, Member $exceptMember) : void
    {
        // Se um membro foi citado usando @, envia a mensagem apenas para ele (mensagem privada).
        // Caso contrário, envia a mensagem para todos os membros
        $mentionedMember = $this->getMentionedMember($message);

        if ($mentionedMember instanceof Member) {
            $this->newMessageTo($message, $mentionedMember);
        } else {
            $this->newMessageToAll($message, $exceptMember);
        }
    }

    private function newMessageTo(string $message, Member $to) : void
    {
        // Envia para um membro específico
        foreach ($this->members as $member) {
            if ($member === $to) {
                $member->write($message);
                break;
            }
        }
    }

    private function newMessageToAll(string $message, Member $exceptMember) : void
    {
        // Envia para todos, exceto para o $exceptMember (quem está enviando a mensagem)
        foreach ($this->members as $member) {
            if ($member !== $exceptMember) {
                $member->write($message);
            }
        }
    }

    private function getMentionedMember(string $message) : ?Member
    {
        \preg_match('/\B@(\w+)/i', $message, $matches);

        $nameMentioned = $matches[1] ?? null;
        if ($nameMentioned !== null) {
            /** @var Member $member */
            foreach ($this->members as $member) {
                if ($member->getName() === $nameMentioned) {
                    return $member;
                }
            }
        }

        return null;
    }
}

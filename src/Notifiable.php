<?php
namespace Rumd3x\Notifier;

use Rumd3x\Notifier\Abstracts\NotifiableAbstract;

class Notifiable extends NotifiableAbstract {

    private $notifications_received = [];

    public function beNotified(Notification $n) {
        $this->notifications_received[] = $n;
    }

    public function getNotificationsReceived() {
        return $this->notifications_received;
    }

    public function getLastNotification() {
        $last = end($this->notifications_received);
        reset($this->notifications_received);
        return $last;
    }
    
}
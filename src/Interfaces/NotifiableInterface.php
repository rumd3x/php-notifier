<?php
namespace Rumd3x\Notifier\Interfaces;

use Rumd3x\Notifier\Notification;

interface NotifiableInterface {
    public function __construct();
    public function addWatcher(NotifiableInterface $notifiable);
    public function watch();
    public function notify(Notification $notification, $who);
    public function beNotified(Notification $notification);
}
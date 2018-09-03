<?php
namespace Rumd3x\Notifier\Abstracts;

use Rumd3x\BaseObject\BaseObject;
use Rumd3x\Notifier\Notification;
use Rumd3x\Notifier\Interfaces\NotifiableInterface;

abstract class NotifiableAbstract extends BaseObject implements NotifiableInterface {

    private static $notifiables = [];
    private $watchers = [];

    public function __construct() {
        self::$notifiables[] = &$this;
    }

    public function addWatcher(NotifiableInterface $notifiable) {
        foreach($this->watchers as $watcher_in_list) {
            if ($notifiable === $watcher_in_list) return;
        }
        $this->watchers[] = $notifiable;
        return $this;
    }

    public function watch() {
        $notifiables = func_get_args();
        foreach($notifiables as $watch) {
            if ($watch instanceof NotifiableInterface) {
                $watch->addWatcher($this);
            } else {
                foreach(self::$notifiables as $notifiable) {
                    if (get_class($notifiable) === $watch) {
                        $notifiable->addWatcher($this);
                    }
                }
            }
        }
    }

    public function notify(Notification $notification, $who = Notification::NOTIFY_ALL) {
        $notifiables = func_get_args();

        foreach($this->watchers as $watcher) {
            $watcher->beNotified($notification);
        }

        foreach(self::$notifiables as $notifiable) {

            if ($notifiable === $this) {
                continue;
            }

            if ($who !== Notification::WATCHING_ONLY) {                
                $notify = (($who === Notification::NOTIFY_ALL) && (!in_array($notifiable, $this->watchers, true)));
                if (!$notify) {
                    foreach($notifiables as $notifiable_class) {
                        if ($notifiable_class instanceof Notification) {
                            continue;
                        }
                        if (($notifiable instanceof $notifiable_class)) {
                            $notify = true;
                            break;
                        }
                    }
                }

                if ($notify) {
                    $notifiable->beNotified($notification);
                }
            }

        }
    }

    abstract public function beNotified(Notification $notification);
}
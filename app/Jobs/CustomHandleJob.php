<?php

namespace App\Jobs;

use App\Jobs\PingJob;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\Jobs\JobName;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\CallQueuedHandler;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Throwable;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob as BaseJob;

class CustomHandleJob extends BaseJob
{

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        $payload = $this->payload();

        $command = $this->payload()['data']['command'];

        // Unserialize the command/class that being sent
        $object = $this->casttoclass('stdClass', unserialize($command));

        // Class that's being called
        $class = $payload['data']['commandName'];

        /**
         * Access the class properties.
         * Make sure that the properties are public,
         * so we can get the properties directly.
         */
        $properties = $object->data;

        /**
         * TODO:
         * Do something with executing the class
         */
    }

    /**
     * Unserialized the class/command
     */
    private function casttoclass($class = 'stdClass', $object)
    {
        return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
    }
}

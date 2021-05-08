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

    public function casttoclass($class, $object)
    {
        // dd(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
        return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
    }
    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        $payload = $this->payload();
        // dd(JobName::parse($payload['job']));
        $command = $this->payload()['data']['command'];
        // dd($command);
        // dd(unserialize($command));
        // dd(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen(\App\Jobs\PingJob::class) . ':"' . \App\Jobs\PingJob::class . '"', ($command)));
try{
$o = $this->casttoclass(\App\Jobs\PingJob::class, unserialize($command));
    dd($o);
}catch(Throwable $e){
    dd($e->getMessage());
}
        
        dd(unserialize(serialize(unserialize($command))));
        // dd(json_decode());
        // CallQueuedHandler
        // dd(utf8_encode($command));

        dd(json_decode(preg_replace('/\s+/', '', $command), true));
        $class = WhatheverClassNameToExecute::class;
        $method = 'handle';

        ($this->instance = $this->resolve($class))->{$method}($this, $payload);
    }

    // /**
    //  * Get the decoded body of the job.
    //  *
    //  * @return array
    //  */
    // public function payload()
    // {
    //     return [
    //         'job'  => 'WhatheverFullyQualifiedClassNameToExecute@handle',
    //         'data' => json_decode($this->getRawBody(), true)
    //     ];
    // }
}

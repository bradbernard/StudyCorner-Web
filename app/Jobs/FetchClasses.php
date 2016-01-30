<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class FetchClasses extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $client = new \GuzzleHttp\Client([
            'cookies'               => true,
            'timeout'               => 20.0,
            'connect_timeout'       => 20.0,
            'verify'                => false,
            'headers'               => [
                'User-Agent'         => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2398.0 Safari/537.36',
               'Accept'             => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
               'Accept-Encoding'    => 'gzip, deflate, sdch',
               'Accept-Language'    => 'en-US,en;q=0.8',
               'Dnt'                => '1',
               'Pragma'             => 'no-cache',
               'Cache-Control'      => 'no-cache',
               'Host'               => 'ais-cs.ucsc.edu',
               'Origin'             => 'https://ais-cs.ucsc.edu',
               'Connection'         => 'keep-alive',
               'DNT'                => 1,
            ]
        ]);

        $login = $client->request('POST', 'https://ais-cs.ucsc.edu/psc/csprd/EMPLOYEE/PSFT_CSPRD/c/SA_LEARNER_SERVICES.SSR_SSENRL_CART.GBL?cmd=login&languageCd=ENG', [
            'form_params' => [
                'timezoneOffset'    => 480,
                'Submit'            => 'Sign In',
                'userid'            => $user->cruz_id,
                'pwd'               => $user->password,
            ]
        ]);

        $html = new \Htmldom();
        $html->load($login->getBody());
        
        $classes = [];
        $rows = $html->find('table.PSLEVEL2GRIDWBO a.PSHYPERLINK');

        foreach($rows as $row) {
            $classes[] = $row->plaintext;
        }

        return $classes;
    }
}
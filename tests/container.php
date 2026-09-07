<?php
declare(strict_types=1);

use Kumwe\Automation\ConfigProvider;
use Kumwe\Automation\Container\CryptographicJitterSourceFactory;
use Kumwe\Automation\Container\JobHandlerRegistryFactory;
use Kumwe\Automation\Container\RetryPolicyFactory;
use Kumwe\Automation\CryptographicJitterSource;
use Kumwe\Automation\JitterSource;
use Kumwe\Automation\JobHandlerRegistry;
use Kumwe\Automation\RetryPolicy;
use Laminas\ServiceManager\ServiceManager;
use Psr\Clock\ClockInterface;

$configuration=(new ConfigProvider())();
check($configuration===(new ConfigProvider())(),'Provider configuration is deterministic');
check($configuration['dependencies']['factories'][RetryPolicy::class]===RetryPolicyFactory::class,'RetryPolicyFactory is explicitly registered');
check($configuration['dependencies']['factories'][JobHandlerRegistry::class]===JobHandlerRegistryFactory::class,'JobHandlerRegistryFactory is explicitly registered');
check($configuration['dependencies']['factories'][CryptographicJitterSource::class]===CryptographicJitterSourceFactory::class,'CryptographicJitterSourceFactory is explicitly registered');
$configuration['kumwe']['automation']['handlers']=['test-handler'];
$configuration['dependencies']['services']=['config'=>$configuration,ClockInterface::class=>$clock,'test-handler'=>$handler];
$services=new ServiceManager($configuration['dependencies']);
check($services->get(JitterSource::class)===$services->get(CryptographicJitterSource::class),'Jitter alias resolves the shared concrete service');
check($services->get(RetryPolicy::class)===$services->get(RetryPolicy::class),'Retry policy is shared');
check($services->get(JobHandlerRegistry::class)===$services->get(JobHandlerRegistry::class),'Handler registry is shared');
check($services->get(JobHandlerRegistry::class)->find('acme.reindex')===$handler,'Registry resolves explicit host handler');
foreach ([['base_delay_seconds'=>'1'],['maximum_delay_seconds'=>0],['unknown'=>true]] as $bad) {
 $services=new ServiceManager(['services'=>['config'=>['kumwe'=>['automation'=>$bad]],ClockInterface::class=>$clock,JitterSource::class=>$jitter]]);
 rejects(fn()=>(new RetryPolicyFactory())($services));
}
foreach ([['handlers'=>['bad'=>1]],['handlers'=>[null]],['handlers'=>['wrong']]] as $bad) {
 $services=new ServiceManager(['services'=>['config'=>['kumwe'=>['automation'=>$bad]],'wrong'=>new stdClass()]]);
 rejects(fn()=>(new JobHandlerRegistryFactory())($services));
}
$services=new ServiceManager(['services'=>[ClockInterface::class=>new stdClass(),JitterSource::class=>$jitter]]);
rejects(fn()=>(new RetryPolicyFactory())($services));

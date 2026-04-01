<?php
declare(strict_types=1);

namespace Exewen\Bol\Middleware;

use Psr\Http\Message\RequestInterface;

class AcceptMiddleware
{
//    private string $config;
    private $config;
    private $channel;

    public function __construct(string $channel, array $config)
    {
        $this->channel = $channel;
        $this->config  = $config;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            // 如果请求已经包含了 Accept header（如 offers接口），则不覆盖
            if ($request->hasHeader('Accept')) {
                return $handler($request, $options);
            }
            $modifiedRequest = $request->withHeader('Accept', 'application/vnd.retailer.v10+json');
            return $handler($modifiedRequest, $options);
        };
    }


}
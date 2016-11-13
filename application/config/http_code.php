<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  提供HTTP状态码信息常量
 */

/**
 * 请求成功状态码列表
 * 200 ~ 299
 */
// 请求执行成功并返回相应数据
defined('HTTP_OK') or define('HTTP_OK', 200);
// 对象创建成功并返回相应资源数据
defined('HTTP_CREATED') or define('HTTP_CREATED', 201);
// 接受请求，但无法立即完成创建行为
defined('HTTP_ACCEPTED') or define('HTTP_ACCEPTED', 202);
// 请求执行成功，不返回相应资源数据
defined('HTTP_NO_CONTENT') or define('HTTP_NO_CONTENT', 204);

/**
 * 重定向状态码列表
 * 重定向的新地址都需要在响应头 Location 中返回
 * 300 ~ 399
 */
// 被请求的资源已永久移动到新位置
defined('HTTP_MOVED_PERMANENTLY') or define('HTTP_MOVED_PERMANENTLY', 301);
// 请求的资源现在临时从不同的 URI 响应请求
defined('HTTP_FOUND') or define('HTTP_FOUND', 302);
// 对应当前请求的响应可以在另一个 URI 上被找到，客户端应该使用 GET 方法进行请求
defined('HTTP_SEE_OTHER') or define('HTTP_SEE_OTHER', 303);
//  资源自从上次请求后没有再次发生变化，主要使用场景在于实现数据缓存
defined('HTTP_NOT_MODIFIED') or define('HTTP_NOT_MODIFIED', 304);
// 对应当前请求的响应可以在另一个 URI 上被找到，客户端应该保持原有的请求方法进行请求
defined('HTTP_TEMPORARY_REDIRECT') or define('HTTP_TEMPORARY_REDIRECT', 307);

/**
 * 客户端错误状态码列表
 */
// 请求体包含语法错误,服务器没有进行新建或修改数据的操作
defined('HTTP_BAD_REQUEST') or define('HTTP_BAD_REQUEST', 400);
// 需要验证用户身份，如果服务器就算是身份验证后也不允许客户访问资源，应该响应 403 Forbidden
defined('HTTP_UNAUTHORIZED') or define('HTTP_UNAUTHORIZED', 401);
// 服务器拒绝执行
defined('HTTP_FORBIDDEN') or define('HTTP_FORBIDDEN', 403);
// 找不到目标资源
defined('HTTP_NOT_FOUND') or define('HTTP_NOT_FOUND', 404);
// 不允许执行目标方法，响应中应该带有 Allow 头，内容为对该资源有效的 HTTP 方法
defined('HTTP_METHOD_NOT_ALLOWED') or define('HTTP_METHOD_NOT_ALLOWED', 405);

/**
 * 服务器错误状态码列表
 */
// 服务器遇到了一个未曾预料的状况，导致了它无法完成对请求的处理。
defined('HTTP_INTERNAL_SERVER_ERROR') or define('HTTP_INTERNAL_SERVER_ERROR', 500);
// 服务器不支持当前请求所需要的某个功能。
defined('HTTP_NOT_IMPLEMENTED') or define('HTTP_NOT_IMPLEMENTED', 501);
//

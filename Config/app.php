<?php
/**
 * ------------------------------------------------------------------
 * 主配置
 * ------------------------------------------------------------------
 *
 */

return [
    /**
     * ------------------------------------------------------------------
     * 环境变量: string
     * ------------------------------------------------------------------
     */
    'env' => env('env', 'prod'),

    /**
     * ------------------------------------------------------------------
     * 是否开启调试模式: bool
     * ------------------------------------------------------------------
     */
    'debug' => env('debug'),

    /**
     * ------------------------------------------------------------------
     * 日志记录类型: string|json [功能暂未实现]
     * ------------------------------------------------------------------
     */
    'log_type' => 'string',

    /**
     * ------------------------------------------------------------------
     * 日志路径(绝对路径): string
     * ------------------------------------------------------------------
     */
    'log_path' => '',

    /**
     * ------------------------------------------------------------------
     * 是否记录请求日志: bool
     * ------------------------------------------------------------------
     */
    'log_request' => true,

    /**
     * ------------------------------------------------------------------
     * 是否记录错误信息: bool
     * ------------------------------------------------------------------
     */
    'log_error' => true,

    /**
     * ------------------------------------------------------------------
     * 是否记录错误trace: bool
     * ------------------------------------------------------------------
     */
    'log_error_trace' => true,

    /**
     * ------------------------------------------------------------------
     * 请求日志记录字段: array
     * ------------------------------------------------------------------
     *
     * 允许值：parameter|header|session|cookie
     *
     * 仅 log_request === true 时生效
     */
    'log_request_field' => ['parameter', 'session', 'cookie', 'header'],

    /**
     * ------------------------------------------------------------------
     * 请求日志记录字段中排除记录的字段: array
     * ------------------------------------------------------------------
     *
     * 允许值：parameter|header|session|cookie
     *
     * 仅 log_request === true 时生效
     */
    'log_request_exclude' => [
        /**
         * 不计入日志的请求参数
         * 例：password
         */
        'parameter' => [
            'password'
        ],

        /**
         * 不计入日志的session
         * 例：username
         */
        'session' => [],

        /**
         * 不计入日志的cookie
         * 例：username
         */
        'cookie' => [],

        /**
         * 不计入日志的header
         * 例：token
         */
        'header' => [
            'Accept-Language', 'Accept-Encoding', 'Accept', 'Upgrade-Insecure-Requests', 'Cache-Control',
            'Connection', 'Host', 'Content-Length', 'Content-Type', 'User-Agent'
        ],
    ]
];

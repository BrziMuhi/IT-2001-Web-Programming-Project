<?php
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Travel Agency API",
 *         description="API for managing tours, bookings, guides, packages, gallery, contacts and users",
 *         version="1.0",
 *         @OA\Contact(
 *             email="muhamed.sekic@stu.ibu.edu.ba",
 *             name="Travel Agency Team"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://localhost/IT-2001-Web-Programming-Project/backend",
 *         description="Local API server"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
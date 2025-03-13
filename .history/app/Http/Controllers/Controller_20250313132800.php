<?php
// app/Http/Controllers/Controller.php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="RBAC Role-Based Access Control API",
 *      version="1.0.0",
 *      description="Comprehensive Role and Permission Management API",
 *      @OA\Contact(
 *          email="support@example.com",
 *          name="API Support"
 *      )
 * )
 * 
 * @OA\Server(
 *      url="/api/v1",
 *      description="Main API Endpoint"
 * )
 * 
 * @OA\SecurityScheme(
 *      securityScheme="bearerToken",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

// Example Role Controller with Swagger Annotations
// app/Http/Controllers/API/RoleController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/roles",
     *     summary="List all roles",
     *     tags={"Roles"},
     *     security={{"bearerToken":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/RoleSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return RoleResource::collection($roles);
    }

    /**
     * @OA\Post(
     *     path="/roles",
     *     summary="Create a new role",
     *     tags={"Roles"},
     *     security={{"bearerToken":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RoleCreateSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Role created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/RoleSchema")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Role creation logic
    }
}

// Swagger Schema Definitions
/**
 * @OA\Schema(
 *     schema="RoleSchema",
 *     title="Role",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(
 *         property="permissions", 
 *         type="array", 
 *         @OA\Items(ref="#/components/schemas/PermissionSchema")
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="RoleCreateSchema",
 *     title="Create Role Request",
 *     @OA\Property(property="name", type="string", example="Administrator"),
 *     @OA\Property(property="slug", type="string", example="admin"),
 *     @OA\Property(
 *         property="permissions", 
 *         type="array", 
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="record_conditions", type="object", nullable=true)
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="PermissionSchema",
 *     title="Permission",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="resource", type="string"),
 *     @OA\Property(property="action", type="string")
 * )
 */
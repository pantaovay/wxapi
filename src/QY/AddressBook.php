<?php
namespace Xueba\WxApi\QY;

use Xueba\WxApi\QY\AddressBook\Department;
use Xueba\WxApi\QY\AddressBook\User;

trait AddressBook
{
    private static $_followUri = 'cgi-bin/user/authsucc';

    private static $_createDepartmentUri = 'cgi-bin/department/create';
    private static $_updateDepartmentUri = 'cgi-bin/department/update';
    private static $_deleteDepartmentUri = 'cgi-bin/department/delete';
    private static $_listDepartmentsUri = 'cgi-bin/department/list';

    private static $_createUserUri = 'cgi-bin/user/create';
    private static $_updateUserUri = 'cgi-bin/user/update';
    private static $_deleteUserUri = 'cgi-bin/user/delete';
    private static $_batchDeleteUserUri = 'cgi-bin/user/batchdelete';
    private static $_getUserUri = 'cgi-bin/user/get';
    private static $_getDepartmentUserUri = 'cgi-bin/user/simplelist';
    private static $_getDepartmentUserDetailUri = 'cgi-bin/user/list';
    private static $_inviteUserUri = 'cgi-bin/invite/send';

    private static $_createTagUri = 'cgi-bin/tag/create';
    private static $_updateTagUri = 'cgi-bin/tag/update';
    private static $_deleteTagUri = 'cgi-bin/tag/delete';
    private static $_getTagUserUri = 'cgi-bin/tag/get';
    private static $_addTagUserUri = 'cgi-bin/tag/addtagusers';
    private static $_deleteTagUserUri = 'cgi-bin/tag/deltagusers';
    private static $_getTagListUri = 'cgi-bin/tag/list';

    /**
     * @param string $userId
     *
     * @return array
     */
    public function follow($userId)
    {
        $response = $this->get(self::$_followUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'userid' => $userId]
        ]);
        return $response->json();
    }

    /**
     * @param Department $department
     *
     * @return int
     */
    public function createDepartment(Department $department)
    {
        $response = $this->post(self::$_createDepartmentUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => $department->toJson(),
        ]);
        return intval($response->json()['id']);
    }

    /**
     * @param Department $department
     *
     * @return array
     */
    public function updateDepartment(Department $department)
    {
        $response = $this->post(self::$_updateDepartmentUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => $department->toJson(),
        ]);
        return $response->json();
    }

    /**
     * @param int $departmentId
     *
     * @return array
     */
    public function deleteDepartment($departmentId)
    {
        $response = $this->get(self::$_deleteDepartmentUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'id' => $departmentId],
        ]);
        return $response->json();
    }

    /**
     * @param int $departmentId
     *
     * @return array
     */
    public function getSubDepartments($departmentId)
    {
        $response = $this->get(self::$_listDepartmentsUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'id' => $departmentId]
        ]);
        return $response->json()['department'];
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function createUser(User $user)
    {
        $response = $this->post(self::$_createUserUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => $user->toJson(),
        ]);
        return $response->json();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function updateUser(User $user)
    {
        $response = $this->post(self::$_updateUserUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => $user->toJson(),
        ]);
        return $response->json();
    }

    /**
     * @param string $userId
     *
     * @return array
     */
    public function deleteUser($userId)
    {
        $response = $this->get(self::$_deleteUserUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'userid' => $userId],
        ]);
        return $response->json();
    }

    /**
     * @param array $userIdList
     *
     * @return array
     */
    public function batchDeleteUser(array $userIdList)
    {
        $response = $this->post(self::$_batchDeleteUserUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode(['useridlist' => $userIdList], JSON_UNESCAPED_UNICODE),
        ]);
        return $response->json();
    }

    /**
     * @param string $userId
     *
     * @return array
     */
    public function getUser($userId)
    {
        $response = $this->get(self::$_getUserUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'userid' => $userId],
        ]);
        return $response->json();
    }

    /**
     * @param int $departmentId
     * @param int $fetchChild
     * @param int $status
     *
     * @return array
     */
    public function getDepartmentUser($departmentId, $fetchChild = 0, $status = 0)
    {
        $response = $this->get(self::$_getDepartmentUserUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'department_id' => $departmentId, 'fetch_child' => $fetchChild, 'status' => $status],
        ]);
        return $response->json()['userlist'];
    }

    /**
     * @param int $departmentId
     * @param int $fetchChild
     * @param int $status
     *
     * @return array
     */
    public function getDepartmentUserDetail($departmentId, $fetchChild = 0, $status = 0)
    {
        $response = $this->get(self::$_getDepartmentUserDetailUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'department_id' => $departmentId, 'fetch_child' => $fetchChild, 'status' => $status],
        ]);
        return $response->json()['userlist'];
    }

    /**
     * @param string $userId
     * @param string $inviteTips
     *
     * @return mixed
     */
    public function inviteUser($userId, $inviteTips = '请关注企业号')
    {
        $response = $this->post(self::$_inviteUserUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode(['userid' => $userId, 'invite_tips' => $inviteTips], JSON_UNESCAPED_UNICODE),
        ]);
        return $response->json();
    }

    /**
     * @param string $tagName
     *
     * @return int
     */
    public function createTag($tagName)
    {
        $response = $this->post(self::$_createTagUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode(['tagname' => $tagName], JSON_UNESCAPED_UNICODE),
        ]);
        return intval($response->json()['tagid']);
    }

    /**
     * @param int $tagId
     * @param string $tagName
     *
     * @return array
     */
    public function updateTag($tagId, $tagName)
    {
        $response = $this->post(self::$_updateTagUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode(['tagid' => $tagId, 'tagname' => $tagName], JSON_UNESCAPED_UNICODE),

        ]);
        return $response->json();
    }

    /**
     * @param int $tagId
     *
     * @return array
     */
    public function deleteTag($tagId)
    {
        $response = $this->get(self::$_deleteTagUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'tagid' => $tagId],
        ]);
        return $response->json();
    }

    /**
     * @param int $tagId
     *
     * @return array
     */
    public function getTagUser($tagId)
    {
        $response = $this->get(self::$_getTagUserUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'tagid' => $tagId],
        ]);
        return $response->json();
    }

    /**
     * @param int   $tagId
     * @param array $userList
     * @param array $partyList
     *
     * return array
     */
    public function addTagUser($tagId, array $userList = array(), array $partyList = array())
    {
        $response = $this->post(self::$_addTagUserUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode(['tagid' => $tagId, 'userlist' => $userList, 'partylist' => $partyList], JSON_UNESCAPED_UNICODE),
        ]);
        return $response->json();
    }

    /**
     * @param int   $tagId
     * @param array $userList
     * @param array $partyList
     *
     * return array
     */
    public function deleteTagUser($tagId, array $userList = array(), array $partyList = array())
    {
        $response = $this->post(self::$_deleteTagUserUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode(['tagid' => $tagId, 'userlist' => $userList, 'partylist' => $partyList], JSON_UNESCAPED_UNICODE),
        ]);
        return $response->json();
    }

    /**
     * @return array
     */
    public function getTagList()
    {
        $response = $this->get(self::$_getTagListUri, [
            'query' => ['access_token' => $this->getAccessToken()],
        ]);
        return $response->json()['taglist'];
    }
}
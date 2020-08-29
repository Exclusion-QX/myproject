<?php

use yii\db\Migration;

/**
 * Class m200828_095600_create_rbac_data
 */
class m200828_095600_create_rbac_data extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Define permissions
        $viewComplaintsListPermission = $auth->createPermission('viewComplaintsList');
        $auth->add($viewComplaintsListPermission);
        $viewPostPermission = $auth->createPermission('viewPost');
        $auth->add($viewPostPermission);
        $deletePostPermission = $auth->createPermission('deletePost');
        $auth->add($deletePostPermission);
        $approvePostPermission = $auth->createPermission('approvePost');
        $auth->add($approvePostPermission);
        $viewUsersListPermission = $auth->createPermission('viewUsersList');
        $auth->add($viewUsersListPermission);
        $viewUserPermission = $auth->createPermission('viewUser');
        $auth->add($viewUserPermission);
        $deleteUserPermission = $auth->createPermission('deleteUser');
        $auth->add($deleteUserPermission);
        $updateUserPermission = $auth->createPermission('updateUser');
        $auth->add($updateUserPermission);

        // Define roles with permissions
        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);
        $auth->addChild($moderatorRole, $viewComplaintsListPermission);
        $auth->addChild($moderatorRole, $viewPostPermission);
        $auth->addChild($moderatorRole, $deletePostPermission);
        $auth->addChild($moderatorRole, $approvePostPermission);
        $auth->addChild($moderatorRole, $viewUsersListPermission);
        $auth->addChild($moderatorRole, $viewUserPermission);
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $moderatorRole);
        $auth->addChild($adminRole, $deleteUserPermission);
        $auth->addChild($adminRole, $updateUserPermission);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200828_095600_create_rbac_data cannot be reverted.\n";

        return false;
    }

}

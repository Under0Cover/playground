<?php

namespace Queries;

class Queries {
    const CHECK_EMAIL = "
        SELECT COUNT(*)
        FROM USERS
        WHERE EMAIL = :EMAIL;
    ";

    const INSERT_USER = "
        INSERT INTO USERS (NAME, PHONE, EMAIL, PASSWORD, PERMISSION)
        VALUES (:NAME, :PHONE, :EMAIL, :PASSWORD, :PERMISSION);
    ";

    const CHECK_USER = "
        SELECT *
        FROM USERS
        WHERE EMAIL = :EMAIL;
    ";

    const INSERT_TASK = "
        INSERT INTO TODOS (USER_ID, TASK_NAME, TASK_DESCRIPTION) 
        VALUES (:USER_ID, :TASK_NAME, :TASK_DESCRIPTION);
    ";

    const GET_TASKS = "
        SELECT *
        FROM TODOS
        WHERE USER_ID = :USER_ID
        AND ACTIVE = 'S';
    ";

    const UPDATE_TASK_STATUS = "
        UPDATE TODOS SET STATUS = 'C', COMPLETED_AT = NOW() WHERE ID = :ID
    ";

    const GET_USERS = "
        SELECT *
        FROM USERS;
    ";

    const GET_TASKS_FOR_ALL = "
        SELECT *
        FROM TODOS
        WHERE USER_ID = :USER_ID
        AND ACTIVE = 'S';
    ";

    const UPDATE_TASK = "
        UPDATE TODOS 
        SET TASK_NAME = :TASK_NAME,
            TASK_DESCRIPTION = :TASK_DESCRIPTION,
            STATUS = :STATUS,
            COMPLETED_AT = :COMPLETED_AT
        WHERE ID = :ID
    ";

    const DELETE_TASK = "
        UPDATE TODOS
        SET TASK_NAME = :TASK_NAME,
            TASK_DESCRIPTION = :TASK_DESCRIPTION,
            STATUS = :STATUS,
            COMPLETED_AT = :COMPLETED_AT,
            ACTIVE = 'N'
        WHERE ID = :ID
    ";
}

?>
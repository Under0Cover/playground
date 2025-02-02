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
        WHERE USER_ID = :USER_ID;
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
        WHERE USER_ID = :USER_ID;
    ";
}

?>
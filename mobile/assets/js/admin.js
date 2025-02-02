document.addEventListener('DOMContentLoaded', function () {
    let currentUser = null;
    let currentTask = null;

    // show tasks event
    document.querySelectorAll('.view-tasks').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            
            document.getElementById('username').textContent = userName;
            
            // show tasks
            const userTasks = document.querySelector(`.user-tasks[data-user-id="${userId}"]`);
            const taskList = document.getElementById('taskList');
            taskList.innerHTML = '';

            userTasks.querySelectorAll('li').forEach(task => {
                const taskName = task.getAttribute('data-task-name');
                const taskId = task.getAttribute('data-task-id');

                const taskItem = document.createElement('li');
                taskItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                taskItem.textContent = taskName;

                const editButton = document.createElement('button');
                editButton.classList.add('btn', 'btn-warning', 'btn-sm', 'edit-task');
                editButton.textContent = 'Editar';
                editButton.setAttribute('data-bs-toggle', 'modal');
                editButton.setAttribute('data-bs-target', '#editTaskModal');
                editButton.setAttribute('data-task-id', taskId);

                taskItem.appendChild(editButton);
                taskList.appendChild(taskItem);
            });
        });
    });

    // add task on front
    document.getElementById('addTaskButton').addEventListener('click', function() {
        const taskTitle = document.getElementById('newTaskTitle').value;
        const taskDescription = document.getElementById('newTaskDescription').value;
        
        if (!taskTitle || !taskDescription) {
            alert('Por favor, preencha tanto o título quanto a descrição da tarefa.');
            return;
        }
    
        // draw on frontend
        const taskList = document.getElementById('taskList');
        const newTaskItem = document.createElement('li');
        newTaskItem.classList.add('list-group-item');

        newTaskItem.innerHTML = `
            <span>${taskTitle}</span> - ${taskDescription}
            <button class="btn btn-warning btn-sm float-end edit-task">Editar</button>
        `;

        // add to list
        taskList.appendChild(newTaskItem);
    
        document.getElementById('newTaskTitle').value = '';
        document.getElementById('newTaskDescription').value = '';

        console.log("Tarefa adicionada com sucesso!");
    });
    

    // edit buton event
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('edit-task')) {
            const taskId = event.target.getAttribute('data-task-id');
            currentTask = document.querySelector(`.list-group-item[data-task-id="${taskId}"]`);

            // task infos by db
            const taskName = currentTask.getAttribute('data-task-name');
            const taskDescription = currentTask.getAttribute('data-task-description');
            const taskStatus = currentTask.getAttribute('data-task-status');
            const taskCreatedDate = currentTask.getAttribute('data-task-created');
            const taskCompletionDate = currentTask.getAttribute('data-task-completion') || 'Em execução';

            document.getElementById('task_id').value = taskId;
            document.getElementById('taskTitle').value = taskName;
            document.getElementById('taskDescription').value = taskDescription;
            document.getElementById('taskStatus').value = taskStatus;
            document.getElementById('taskCreatedDate').value = taskCreatedDate;
            document.getElementById('taskCompletionDate').value = taskCompletionDate;
        }
    });

    // close any modal
    function closeModal() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }
});

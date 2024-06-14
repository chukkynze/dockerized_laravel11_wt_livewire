# Dockerized Laravel Livewire Todo App #

A very simple Laravel web application for project & task management:

- Create Project (info to save: project name, start & due dates, priority, timestamps)
- Edit Project
- Mark Project deleted
- Projects should be saved to a mysql table.
- Create task (info to save: task name, status, priority, timestamps)
- Edit task
- Mark task deleted
- (In progress) Reorder tasks with drag and drop in the browser.
    - Priority should automatically be updated based on this.
    - #1 priority goes at top, #2 next down and so on.
- Tasks should be saved to a mysql table.
- Project & Tasks relationship:
    - add project functionality to the tasks.
    - User should be able to select a project from a dropdown and only view tasks associated with that project.

- Notes:
  - well-written & readable code
  - Tests
  - Done the Laravel way.

Include any instructions on how to set up & deploy the web application in your Readme.md file in the project directory.


## What you need to know ###

1. Prerequisites
2. Set Up The Environment
3. Environment Configurations
5. Set Up Everything Else
6. Database Configuration
7. How to run tests
8. Deployment instructions
9. Debugging
10. Testing

### 1. Prerequisites & Dependencies
* The assumption is that your host machine is a Linux box (too bad, Apple fanboys!)
* A terminal outside your IDE on the host machine
    * Since we are working with a lot of files, IDEs may start to use up your devices resources in an attempt to index and re-index files
    * Ideally, start using your regular terminal from this point until you are ready. After setup, you can return to your IDE without a resource drain.
* Docker Desktop for Mac - If you're on Linux you don't need this
* Also, if you are on a Mac, install Xcode and Homebrew on your HOST machine. On Ubuntu, at least Homebrew ... I think.
* Update and Restart your Docker Desktop just to be safe.
* Do not start off as root. It's not impossible, but, these instructions assume (as is the norm) that you are logged in and
  acting as your regular user.
* Find out your device user's name by running this in a terminal (Linux):
    ```
    whoami
    ```
  The output is a text string of your username, which will be represented in this readme in this format `<username>`, for instance `chukky`
* Then find out the `id`'s associated with your user by running this:
    ```
    id <username>
    ```
  Example:
    ```
    id chukky
    ```
* In the output you will see a uid number, a gid number and an admin number. Note the numbers and your username
* At this point, you are ready to set up your environment from a fresh install


***


### 2. Set Up The Environment - Fresh Install
* On your host machine/device, go to your `Home` folder and run this to create your new environment location:
  ```
  mkdir -p ~/chukkys-code/environment
  ```
* The names are not important, but they must be under your home folder to manage permissions properly.
* The names `chukkys-code/environment` or `PROJECT_LOCATION` will be how these locations are referenced as we continue.
* Get the code for your environment by running the following git clone command:
  ```
  git clone git@bitbucket.org:chukkynze0/docker_laravel_livewire_api.git ~/chukkys-code/environment
  ```
  then (optionally) cd into the environment folder and run this to make sure you own all the files
  ```
  sudo chown -R <username>:staff .
  ```
  * Once you have finished cloning the repo into your environment location and switching the ownership, run this to get your environment ready for the fresh install
    ```
    cp -a -n .env.docker-compose.example .env.docker-compose
    ```
  * This will create a docker environment file which you will need to update before going on
      * In the newly created `.env.docker-compose` file, update the following values:
        ```
        DEVICE_USER_FIRST_NAME='First'
        DEVICE_USER_FULL_NAME='First Last'
        DEVICE_HOST_USERNAME=<username>
        DEVICE_HOST_UID=<uid>
        DEVICE_HOST_GID_STAFF=<gid>
        DEVICE_HOST_GID_ADMIN=<admin id number>
        DEVICE_HOST_IP=<your host ip>
        ```
      * To something similar to this example:
        ```
        DEVICE_USER_FIRST_NAME='Chukky'
        DEVICE_USER_FULL_NAME='Chukky Nze'
        DEVICE_HOST_USERNAME=chukky
        DEVICE_HOST_UID=501
        DEVICE_HOST_GID_STAFF=20
        DEVICE_HOST_GID_ADMIN=80
        DEVICE_HOST_IP=host.docker.internal
        ``` 
  * Don't bother with any other variables for now. That'll come later.

* Once, you have completed all the prep tasks, run the following as your regular user and enter your password when prompted:
* NOTE: DANGER - THIS WILL DESTROY YOUR EXISTING ENVIRONMENT AND YOUR EXISTING PROJECTS INCLUDING IDE SETTINGS (If any)
    * There is a backup coded into the process but the danger still stands
* NOTE: WARNING - This will cause full IDEs like PhpStorm to hog resources while attempting to index and re-index files. Use the device terminal preferably.
* If you accept this mission, cd into your environment folder `cd ~/chukkys-code/environment` and run the following:
* ```
  make fresh_install
  ```


***


### 3. Environment Configurations
* cd into your environment `cd ~/chukkys-code/environment` and run:
  ```    
  make boot_clean
  ```

  ```
  TIP:
  Personally, I would run the above `make boot_clean` command in its own terminal or tab (IDE or device terminal) and leave it alone. 
  This will continuously output the stdout and stderr for all the containers in the environment. It is great for 
  debuggin live issues, but it very noisy. I just run it in it's own tab and go about my work some where else.
  But, that's just me. You also have the option to run it in the background with
  ```

  ````
  make boot_bg_clean
  ````


This will launch your entire codebase setup in a virtual environment that we will call `guest`. Your actual device is still the `host`.
* Note: `boot_clean` is designed to wipe out all previous docker setups, create new ones, and log the entire environment activity out to
  the screen. It may go crazy for a while (about 30 minutes). No worries. It's expected, and you won't be using this command a lot.
* When `boot_clean` (or `boot_bg_clean`) is done running, go to `http://localhost:8080/` and you should see XXXXXXXX.


***

### Setup Instructions - Everything Else

When `make boot_clean` is done, you will see different colored output logs on your screen for the different services that are
running (mainly for grafana). Open a new terminal/tab, still on your `host`, cd into your environment: `cd ~/chukkys-code/environment` and run this code:
```
make webapp_setup
```
That's it. You can play around with the livewire interface and if you want to reset the project, run ```make webapp_setup``` again
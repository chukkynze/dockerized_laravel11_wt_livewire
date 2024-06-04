# Dockerized Laravel Livewire Todo App #

Create a very simple Laravel web application for task management:

- Create task (info to save: task name, priority, timestamps)
- Edit task
- Delete task
- Reorder tasks with drag and drop in the browser.
    - Priority should automatically be updated based on this.
    - #1 priority goes at top, #2 next down and so on.
- Tasks should be saved to a mysql table.
- BONUS POINT:
    - add project functionality to the tasks.
    - User should be able to select a project from a dropdown and only view tasks associated with that project.

You will be graded on how well-written & readable your code is, if it works, and if you did it the Laravel way.

Include any instructions on how to set up & deploy the web application in your Readme.md file in the project directory.


## What you need to know ###

1. Quick Summary
2. Prerequisites & Dependencies
3. Set Up The Cubicle
4. Environment Configurations
5. Set Up Everything Else
6. Database Configuration
7. How to run tests
8. Deployment instructions
9. Debugging
10. Testing

### Prerequisites & Dependencies
* There are some tools you should have ready:
    * A terminal outside your IDE on the host machine
        * Since we are working with a lot of files, IDEs may start to use up your devices resources in an attempt to index and re-index files
        * Ideally, start using your regular terminal from this point until you are ready. After setup, you can return to your IDE without a resource drain.
    * Docker Desktop for Mac - If you're on Ubuntu you don't need this
    * Also, if you are on a Mac, install Xcode and Homebrew on your HOST machine. On Ubuntu, at least Homebrew ... I think.
    * Update and Restart your Docker Desktop just to be safe.
* A password-less SSH Key for use with access to the Savi Bitbucket Workspace.
    * Add your SSH Key to Bitbucket
        -   Make one if you don't have one using [these instructions](https://confluence.atlassian.com/bitbucket/set-up-an-ssh-key-728138079.html)
        -   Do not create a passphrase when prompted.
        -   Optionally, add your ssh key to the agent when prompted.
    * Ensure your SSH key is added to the repositories you will be working with.
    * Talk to your manager to gain access to the following repos:
        * This one - The Cubicle
        * The Main App - app.bysavi.com
        * Calc API - calc.bysavi.com
        * (optional) Savi Tools - savi-tools
        * (optional) Data API
* Do not start off as root. It's not impossible, but, these instructions assume (as is the norm) that you are logged in and
  acting as your regular user.
    * Find out your device user's name by running this in a terminal:
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
* At this point, you are ready to set up your cubicle from a fresh install


***

### Set Up The Cubicle - Fresh Install
* On your host machine/device, go to your `Home` folder and run this to create your new cubicle location:
  ```
  mkdir -p ~/savi-code/cubicle
  ```
* The names are not important, but they must be under your home folder to manage permissions properly.
* The names `savi-code/cubicle` will be how these locations are referenced as we continue.
* Get the code for your cubicle by running the following git clone command:
  ```
  git clone git@bitbucket.org:teamsavi/cubicle.git ~/savi-code/cubicle
  ```
  then (optionally) cd into the cubicle folder and run this to make sure you own all the files
  ```
  sudo chown -R <username>:staff .
  ```
* Once you have finished cloning the repo into your cubicle location and switching the ownership, run this to get your cubicle ready for the fresh install
    * ```
    make cbcl_prep_fresh_install
    ```
    * This will:
        * Create a docker environment file which you will need to update before going on
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
        * Automatically create self-signed SSL certs for the environment. No action for you to do.
        * etc

* Once, you have completed all the prep tasks, run the following as your regular user and enter your password when prompted:
* NOTE: DANGER - THIS WILL DESTROY YOUR EXISTING ENVIRONMENT AND YOUR EXISTING PROJECTS INCLUDING IDE SETTINGS (If any)
    * There is a backup coded into the process but the danger still stands
* NOTE: WARNING - This will cause full IDEs like PhpStorm to hog resources while attempting to index and re-index files. Use the device terminal preferably.
* If you accept this mission, cd into your cubicle folder `cd ~/savi-code/cubicle` and run the following:
* ```
  make cbcl_fresh_install
  ```
* This will set your cubicle up and get you prepared to configure the following repos for now:
    * This one - The Cubicle
    * The Main App - app.bysavi.com




***

### Environment Configurations
* Accessing each site from the host is governed by a nginx reverse proxy server running on the host that should now be
  already installed and configured using the stub at `stubs/rev_proxy_nginx.conf.stub`.
* Each repo is configured using `.env` files. Go through each repo and ensure that the `.env` file for each project
  has the proper values before continuing.
* Add this line to your `/etc/hosts`
  ```
  127.0.0.1 local.bysavi.test local-partner.bysavi.test local-partner1.bysavi.test local-partner2.bysavi.test local-crisis.bysavi.test
  ```
  You can add other partners as well


* In each repo **that is already configured to work with your cubicle**, there should be an `.env.cubicle` file.
  Tweak the default values to your liking. There should also be a cubicle folder. Your cubicle will copy bash and other files there
  to perform certain tasks. Don't delete that folder or the .gitignore file within.

* When you have each repo's config files sufficiently ready, cd back into your cubicle `cd ~/savi-code/cubicle` and run:
  ```    
  make boot_clean
  ```

  ````
  TIP:
  Personally, I would run the above `make boot_clean` command in its own terminal or tab (IDE or device terminal) and leave it alone. 
  This will continuously output the stdout and stderr for all the containers in the cubicle. It is great for 
  debuggin live issues, but it very noisy. I just run it in it's own tab and go about my work some where else.
  But, that's just me. You also have the option to run it in the background with 
  
  make boot_bg_clean
  ````


This will launch your entire codebase setup in a virtual environment that we will call `guest`. Your actual device is still the `host`.
* Note: `boot_clean` is designed to wipe out all previous docker setups, create new ones, and log the entire environment activity out to
  the screen. It may go crazy for a while (about 30 minutes). No worries. It's expected, and you won't be using this command a lot.
* When `boot_clean` (or `boot_bg_clean`) is done running, go to `http://127.0.0.1:8181/` or `http://local.bysavi.test/` and you should see raw php errors.
  ````
  TIP:
  There is a handy chrome plugin for all of the urls needed to access the services in your cubicle. To install it in your Chrome browser, follow these steps:
  - Go to chrome://extensions/ in your browser
  - Click the "Load unpacked" buttom at the top left. A folder selection dialog box will open
  - Go to the "third_party/chrome plugin/app" folder and select it. It is now loaded
  - In your browser plugin section, you can now pin the plugin and use as needed
  ````

***

### Setup Instructions - Everything Else

When `make boot_clean` is done, you will see different colored output logs on your screen for the different services that are
running (mainly for grafana). Open a new terminal/tab, still on your `host`, cd into your cubicle: `cd ~/savi-code/cubicle` and run this code:
```
make cbcl_setup_all
```
This will set up all of your repos in their appropriate docker containers and takes a while. We're talking about XX minutes! There will be repo specific actions to do for each. They are found below:

####  The Cubicle

####  The Main App

***

### Database Configuration

#### MySQL


***

### Debugging

####  Main App (Xdebug)
- These instructions are based off of this [documentation](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html) for the PhpStorm IDE. Steps for other similar IDE's should be intuitive.
- Make sure the docker "Cubicle" is already running. Follow the steps in the `Setup Instructions` before continuing here.
- Open PhpStorm | Preferences | PHP
  ![PhpStormPrefernces.png](documentation/images/setup/debugging/PhpStormPrefernces.png)

- Click the `...` at the end of CLI Interpreter to open the CLI Interpreter dialog box
- ![CLI_InterpreterDialog.png](documentation/images/setup/debugging/CLI_InterpreterDialog.png)
- Find the "Server" input and then find the `New` button and click that to open the new server dialog box
- ![NewServerViaDocker.png](documentation/images/setup/debugging/NewServerViaDocker.png)
- The box should already have found the current running docker instance (via Docker for Mac). Make sure the connection is successful, name it and click `OK`.
- The name of your new Server should populate the Server input in the CLI Interpreters dialog box.
- Search for the docker compose file of your work environment and select the container for the main app
- Select `Connect to existing container`
- Refresh the PHP executable. You should see the correct output info appear. Click `OK`
- Your info should have already populated the appropriate fields in Preferences. If not do so manually.
- Open PhpStorm | Preferences | PHP | Debug and follow the instructions in the [documentation](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html) for Debug settings
- Add a new PhpStorm configuration by clicking `Edit Configurations` in the Run bar
- ![RunBar_EditConfigurations.png](documentation/images/setup/debugging/RunBar_EditConfigurations.png)
- Click the `+` to add a new configuration.
- ![DebuggerDialog.png](documentation/images/setup/debugging/DebuggerDialog.png)
- Choose PHP Remote Debug. Name the debugger XDebug (or Bug Finder Extraordinaire - i don't care) and enter `PHPSTORM` AS THE IDE key.
- Click the `...` to add a new server. Name it, add `host.docker.internal` as the host and enter the value of the `APP_BY_SAVI_WEB_NGINX_PORT` environment variable - default is `8181`
  ![ServersDialogFromDebugConfigurations.png](documentation/images/setup/debugging/ServersDialogFromDebugConfigurations.png)
- Click `OK` to close the Servers dialog
- Click `OK` again.
- Go to your `index.php` in your IDE and add a breakpoint and `phpinfo()` at the first line
- ![IndexBreakPoint.png](documentation/images/setup/debugging/IndexBreakPoint.png)
- Go to your browser at `http://127.0.0.1:8181/` and setup and turn on your favorite debug tool
  ![BrowserDebugTool.png](documentation/images/setup/debugging/BrowserDebugTool.png)
- Back in PhpStorm select your debugger run config, make sure it's listening, and start the debugger
  ![StartDebugger.png](documentation/images/setup/debugging/StartDebugger.png)
- In your browser, refresh `http://127.0.0.1:8181/`. Your IDE should catch the call at the break point.
- XDebug is setup
  ![XDebugSetup.png](documentation/images/setup/debugging/XDebugSetup.png)

## Contribution guidelines ###

* Code review
* Other guidelines

## Who do I talk to? ###

* Team contact: chukkynze@gmail.com

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact
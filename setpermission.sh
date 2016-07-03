#!/bin/bash

sudo chgrp www-data ..
sudo chmod 775 ..

sudo chgrp www-data yii
sudo chmod 775 yii


sudo chgrp -R www-data behaviors
sudo chmod -R 775 behaviors

sudo chgrp -R www-data config
sudo chmod -R 775 config

sudo chgrp -R www-data controllers
sudo chmod -R 775 controllers

sudo chgrp -R www-data gii
sudo chmod -R 775 gii

sudo chgrp -R www-data helpers
sudo chmod -R 775 helpers

sudo chgrp -R www-data libraries
sudo chmod -R 775 libraries

sudo chgrp -R www-data models
sudo chmod -R 775 models

sudo chgrp -R www-data runtime
sudo chmod -R 777 runtime

sudo chgrp -R www-data views
sudo chmod -R 775 views

sudo chgrp -R www-data web
sudo chmod -R 775 web

sudo chgrp -R www-data web/assets
sudo chmod -R 777 web/assets


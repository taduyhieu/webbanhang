Git global setup
git config --global user.name "Đỗ Minh Tú"
git config --global user.email "minhtudo1992@gmail.com"

Create a new repository
git clone http://gitstore.thcustomer.com/minhtu/THC-VCCI.git
cd THC-VCCI
touch README.md
git add README.md
git commit -m "add README"
git push -u origin master

Existing folder
cd existing_folder
git init
git remote add origin http://gitstore.thcustomer.com/minhtu/THC-VCCI.git
git add .
git commit -m "Initial commit"
git push -u origin master

Existing Git repository
cd existing_repo
git remote rename origin old-origin
git remote add origin http://gitstore.thcustomer.com/minhtu/THC-VCCI.git
git push -u origin --all
git push -u origin --tags
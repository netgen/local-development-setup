# Set up Git version control system

## 1 Configure

Create `.gitconfig` file in your home directory with the following content:

```dosini
[user]
    email = brale@netgen.io
    name = Brale Rodijak
[core]
    excludesfile = /Users/brale/.gitignore
[diff]
    indentheuristic = true
    wsErrorHighlight = all
[pull]
    ff = only
[log]
    follow = true
```

Optionally add the alias section with some useful aliases:

```dosini
[alias]
    tree = log --graph --decorate --pretty=oneline --abbrev-commit
    l = log --decorate --graph --date=short --pretty=\"format:%C(blue)%ad%Creset %C(yellow)%h%C(green)%d%Creset %C()%s %C(black) [%an]%Creset\"
    ls = log --pretty=format:"%C(yellow)%h%Cred%d\\ %Creset%s%Cblue\\ [%cn]" --decorate
    lg = log --color --graph --abbrev-commit --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr)%C(bold blue)<%an>%Creset'
    ll = log --pretty=format:"%C(yellow)%h%Cred%d\\ %Creset%s%Cblue\\ [%cn]" --decorate --numstat
    branch-name = "!git rev-parse --abbrev-ref HEAD"
    update = "!f() { git fetch origin --prune && (git merge --ff-only origin/$(git branch-name) || git rebase --preserve-merges origin/$(git branch-name)); }; f"
    whatis = show -s --pretty='tformat:%h (%s, %ad)' --date=short
```

Create `.gitignore` file in your home directory with the following content:

```dosini
.DS_Store
.idea
```

## 2 Install

Even if you OS already comes with `Git` installed, you should install a newer
version using a package manager.

### 2.1 If using MacOS with MacPorts

Execute on the command line:

```console
sudo port install git
```

### 2.2 If using MacOS with Homebrew

Execute on the command line:

```console
brew install git
```

### 2.3 If using Ubuntu

Execute on the command line:

```console
sudo apt install git
```

## 3 Verify configuration

Check your configuration is active by executing on the command line:

```console
git config --list
```

In the command output you should see your configuration data.

# Tips

* You can maintain your own private ignore file through `.git/info/exclude` file
found in your project directory.

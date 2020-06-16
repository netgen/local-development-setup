# Install and configure `Git` version control system

## 1 Create `git` configuration

Create `.gitconfig` file in your home directory with the following content:

```dosini
[user]
    email = brale@netgen.io
    name = Brale Rodijak
[core]
    excludesfile = /Users/brale/.gitignore
[diff]
    indentheuristic = true
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

## 2 Install newer version of `git`

### 2.1 If using `MacOS` with `MacPorts`

```console
sudo port install git
```

### 2.2 If using `MacOS` with `Homebrew`

```console
brew install git
```

## 3 Verify configuration

Check your configuration is active by executing:

```console
git config --list
```

In the command output you should see your configuration data.

# Tips

* You can maintain your own private ignore file through `.git/info/exclude` file
found in your project directory.

#!/usr/bin/env bash

if [ $# -eq 0 ]; then
    echo "Usage: [mode] is requried" 1>&2
    exit 1
fi

declare -A modes
modes["staging"]="main"

if [[ ! -v modes[$1] ]]; then
    echo "Only mode staging or develop are supported" 1>&2
    exit 1
fi

tmp_dir='storage/deploy-tmp'
mode="$1"
branch="${modes[$1]}"

echo "building ${mode} for ${branch}"

if command -v pnpm &> /dev/null; then
    pnpm build --mode $mode
fi

find $tmp_dir -depth 1 ! -name .git ! -name $tmp_dir -exec rm -rf {} +

git archive --format tar --prefix deploy-tmp/ HEAD | (cd storage && tar xf -)

rm -rf $tmp_dir/public/{.gitignore,build}

rsync -av --exclude='*.map' public/build $tmp_dir/public/

cd $tmp_dir

git checkout $branch --force
git add -A && git commit -sm "chore: update $(date +'%Y-%m-%d %H:%M')"
git push origin -u $branch:$branch

cd -

# energybubble.net


## Development environment

### Set up
Run `npm install` or `npm i` in the project root to install the node packages.

### Running
Run `npm start` in the project root to spin up the development environment.

To test the Netlify CMS environment locally, run `npx netlify-cms-proxy-server` first, then open a new terminal and run `npm start`.


## Staging release
- Merge working code to `staging` branch
- Push staging branch to trigger build and deploy to http://staging.energybubble.net


## Production release

This repository follows GitHub Flow; each feature branch should be deployed straight to `main` branch. Before pushing the branch for the final time:

- Update the .changelog with details of what has been added/changed/fixed/removed
- Bump the version number:
    - For a major  `npm run bump:major`
    - For a minor  `npm run bump:minor`
    - For a patch  `npm run bump:patch`

The branch can then be pushed. Tagging with the version number will be carried out automatically (via a GitHub Action) when the branch is merged to `main`.

module.exports = {
  apps: [
    {
      name: 'docker-compose',
      script: 'sudo docker-compose up --build',
      autorestart: true,
      max_restarts: 10,
      instances: 1,
      exec_mode: 'fork',
      watch: false,
      env: {
        NODE_ENV: 'production'
      }
    }
  ]
};

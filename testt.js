const { exec } = require('child_process');
exec('ls', (error, stdout, stderr) => {
  console.log(stdout);
});

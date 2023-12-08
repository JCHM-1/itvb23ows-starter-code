/* Requires the Docker Pipeline plugin */
pipeline {
    agent {
        agent { docker { image 'php:8.3.0-alpine3.18' } }
    }
    stages {
        stage('Build') {
            steps {
                sh 'echo "Hello World"'
                sh '''
                    echo "Multiline shell steps works too"
                    ls -lah
                '''
            }
        }
    }
}
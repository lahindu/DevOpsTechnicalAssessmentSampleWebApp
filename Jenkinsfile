pipeline {
    agent any
    stages {
        stage('BUILD') {
            steps {
                println "build stage"
                sh 'docker build . -t 202256309025.dkr.ecr.ap-southeast-1.amazonaws.com/sample-web:v1'
                withCredentials([usernamePassword(credentialsId: 'ecr-login', passwordVariable: 'password', usernameVariable: 'username')]) {
                    sh 'docker login --username $username --password $password 202256309025.dkr.ecr.ap-southeast-1.amazonaws.com'
                }
                sh 'docker push 202256309025.dkr.ecr.ap-southeast-1.amazonaws.com/sample-web:v1'
                sh 'docker logout'
            }
        }
        stage('DEPLOY') {
            steps {
                sh "sed -i 's/IMAGETAG/v1/g' K8s/Web/web-deployment.yml"
                sh 'kubectl apply -f K8s/Web/'
                sh 'kubectl rollout status deployment/sample-web-deployment -n web-dmz --timeout=6m --watch=true'
                sh 'if $? -ne 0; then exit 1; fi'
                sh 'kubectl apply -f K8s/App/'
                
            }
        }
        stage('ClearDir') {
            steps {
                cleanWs()
            }
        }
    }
}

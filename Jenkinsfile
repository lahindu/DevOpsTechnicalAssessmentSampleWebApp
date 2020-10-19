pipeline {
    agent any
    environment{
        ECR_REPO="xxxxxxxxxxxxxx.dkr.ecr.ap-southeast-1.amazonaws.com/sample-web"
        ECR_URL="xxxxxxxxxxxxx.dkr.ecr.ap-southeast-1.amazonaws.com"
        ELB_DNS="xxxxxxxxxxxxxxx-92fd7f8a2c40aead.elb.ap-southeast-1.amazonaws.com"
    }
    stages {
        stage('BUILD') {
            steps {
                println "build stage"
                sh "docker build . -t ${ECR_REPO}:${env.GIT_COMMIT}"
                withCredentials([usernamePassword(credentialsId: 'ecr-login', passwordVariable: 'password', usernameVariable: 'username')]) {
                    sh "docker login --username $username --password $password ${ECR_URL}"
                }
                sh "docker push  ${ECR_REPO}:${env.GIT_COMMIT}"
                sh 'docker logout'
            }
        }
        stage('DEPLOY') {
            steps {
                sh "sed -i 's/IMAGETAG/'${env.GIT_COMMIT}'/g' K8s/Web/web-deployment.yml"
                sh "sed -i 's/ELB_DNS/'${ELB_DNS}'/g' K8s/Web/ingress.yml"
                sh 'kubectl apply -f K8s/namespace.yml'
                sh 'kubectl apply -f K8s/storage-class.yml'
                sh 'kubectl apply -f K8s/Web/'
                sh 'kubectl rollout status deployment/sample-web-deployment -n web-dmz --timeout=6m --watch=true'
                sh 'if [ $? -ne 0 ]; then exit 1;  fi'
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

# build stage
FROM node:16 as build-stage

ENV TZ="Asia/Damascus"

WORKDIR /app

COPY package*.json ./

RUN npm install --legacy-peer-deps

COPY . .

RUN npm run build-prod

# production stage

FROM nginx  as production-stage

COPY --from=build-stage /app/dist /usr/share/nginx/html

COPY default.conf /etc/nginx/conf.d/

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

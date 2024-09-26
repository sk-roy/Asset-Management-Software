<template>
    <v-container>   
      <v-col cols="12">
      <v-row>
        <h3 v-if="documents && documents.length > 0">Documents</h3>
      </v-row>
      
      <!-- Display and Download Documents -->
      <v-row>
        <v-col cols="12">
          <v-list>
            <v-list-item
              v-for="(document, index) in documents"
              :key="index"
            >
                <v-row>
                  <v-col>                    
                    <a
                      href="#"
                      @click.prevent="downloadDocument(document)"
                      class="p-1"
                      style="text-decoration: none"
                    >
                      <v-list-item-title>{{ document.name }}</v-list-item-title>
                    </a>
                    <v-list-item-subtitle>{{ formatDate(document.created_at) }}</v-list-item-subtitle>
                  </v-col>
                  <v-col>                    
                    <v-btn icon @click="deleteDocument(document)" variant="secondary">
                      <v-icon color="red">mdi-delete</v-icon>
                    </v-btn>    
                  </v-col>
                </v-row>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="8">
          <h4>Upload Document</h4>
          <v-file-input
            v-model="documentFile"
            label="Select a document"
            accept=".pdf,.doc,.docx,.jpg,.png"
            variant="outlined"
            density="compact"
            required
          ></v-file-input>
        </v-col>
        <v-col cols="4" class="d-flex align-center justify-center gap-10">
            <v-btn color="primary" @click="uploadDocument">Upload</v-btn>
        </v-col>
      </v-row>
  
    </v-col>    
    </v-container>
  </template>
  
  <script>
import apiClient from '@/plugins/axios';
import { format } from 'date-fns';

  export default {
    props: {
      pAsset: null,
    },
    data() {
      return {
        documentFile: null, // Holds the selected file
        documents: this.pAsset.documents,
      };
    },
    methods: {

      async uploadDocument() {
        try {
          if (!this.documentFile) return;
    
          const formData = new FormData();
          formData.append('document', this.documentFile);
          formData.append('asset_id', this.pAsset.id);
    
          const response = await apiClient.post(`/documents`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });

          this.documentFile = null;
          if (response.data.success) {
            this.documents.push(response.data.data);
          }
        
        } catch (error) {
          console.error("Document upload failed:", error);
          alert("Failed to upload the document.");
        }
      },
  
      // Handle document download
      async downloadDocument(file) {
        console.log('downloadDocument');
        try {
          const response = await apiClient.get(`/documents/${file.id}`, {
            responseType: "blob",
          });

          
          console.log('downloadDocument', response);

          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", `${file.name}.pdf`);
          document.body.appendChild(link);
          link.click();
          link.remove();
        } catch (error) {
          console.error("Document download failed:", error);
          alert("Failed to download the document.");
        }
      },

      async deleteDocument(document) {
        if (confirm("Are you sure?")) {
          try {
            await apiClient.delete(`/documents/${document.id}`);
          } catch (error) {
            console.error("Failed to delete document:", error);
            alert("Failed to delete the document.");
          }
        }
      },
    
      formatDate(date) {
          return format(date, 'hh:mm a, MMMM dd, yyyy');
      },
    },
    mounted() {
    }
  };
  </script>
  
<template>
    <v-row>
      <v-col cols="12">
        <h3>Notes</h3>
        
        <!-- Display Notes -->
        <v-list v-if="asset.notes && asset.notes.length > 0">
          <v-list-item v-for="(note, index) in asset.notes" :key="note.id">
            <v-list-item-content>
              <v-list-item-title>{{ note.title }}</v-list-item-title>
              <v-list-item-subtitle>{{ formatDate(note.created_at) }}</v-list-item-subtitle>
            </v-list-item-content>
  
            <!-- Edit and Delete Buttons -->
            <v-list-item-action>
              <v-btn icon @click="editNote(note)" variant="secondary">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn icon @click="deleteNote(note.id)" variant="secondary">
                <v-icon color="red">mdi-delete</v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
        </v-list>  
        <!-- No notes message -->
        <v-alert v-else type="info">No notes available.</v-alert>

        <v-row>
            <v-col cols="8">
                <h4>{{ this.editing ? 'Editing note' : 'Create New Note' }} </h4>
                <v-textarea
                v-model="nNote.title"
                label="New Note"
                variant="outlined"
                density="compact"
                rows="2"
                required
                ></v-textarea>
            </v-col>
            <v-col cols="4" class="d-flex align-center justify-center gap-10">
                <v-btn v-if="!this.editing" type="submit" color="primary" @click="createNote">Create</v-btn>
                <v-btn v-if="this.editing" type="submit" color="primary" @click="cancelEdit">Cancel</v-btn>
                <v-btn v-if="this.editing" type="submit" color="primary" @click="saveEditedNote">Done</v-btn>
            </v-col>
        </v-row>
  
    </v-col>
    </v-row>
  </template>
  
  <script>
import apiClient from '@/plugins/axios';
import store from '@/store';
import { format } from 'date-fns';

  export default {
    data() {
      return {
        asset: this.assetProp,
        editDialogVisible: false,
        editNoteContent: '',
        editingNote: null, // The note being edited
        editing: false,
        nNote: {
            title: '',
            description: '',
            asset_id: this.assetProp.id,
        }
      };
    },
    props: {
      assetProp: Object, // Passed from parent component or API
    },
    methods: {
      async createNote() {        
        try {
            if (this.nNote.title.trim() === '') return;  
            await apiClient.post("/notes", this.nNote);        
            this.nNote.title = '';
            this.reloadAsset();
        } catch (error) {
            console.error("Failed to create new note:", error);
            alert("Failed to create new note.");
        }
      },
  
      // Edit an existing note
      editNote(note) {
        this.nNote = note;
        this.editing = true;
        this.reloadAsset();
      },
  
      // Save the edited note
      async saveEditedNote() {
        try {
            if (this.nNote.title.trim() === '') return;    
            await apiClient.patch(`/notes/${this.nNote.id}`, this.nNote);        
            this.nNote.title = '';
            this.editing = false;
            this.reloadAsset();
        } catch (error) {
            console.error("Failed to delete note:", error);
            alert("Failed to delete note.");
        }
      },
  
      // Cancel editing
      cancelEdit() {
        this.nNote.title = "";
        this.editing = false;
      },
  
      // Delete a note
      async deleteNote(noteId) {      
        try {
            await apiClient.delete(`/notes/${noteId}`);  
            this.reloadAsset();
        } catch (error) {
            console.error("Failed to delete note:", error);
            alert("Failed to delete note.");
        }
      },
    
        formatDate(date) {
            return format(date, 'hh:mm a, MMMM dd, yyyy');
        },
        
        async reloadAsset() {
            await store.dispatch('fetchAssetDetails', { id: this.assetProp.id });
            this.asset = store.getters.getAssetDetails(this.assetProp.id);
        },
    },
  };
  </script>
  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  
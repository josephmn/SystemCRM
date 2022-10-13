using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CEvaluacionPersona
    {
        public List<EEvaluacionPersona> ListadoEvaluacion(SqlConnection con, String dni)
        {
            List<EEvaluacionPersona> lEvaluacionPersona = null;
            SqlCommand cmd = new SqlCommand("ups_evaluacion_persona", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@v_dni", SqlDbType.Int).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEvaluacionPersona = new List<EEvaluacionPersona>();

                EEvaluacionPersona obEvaluacionPersona = null;
                while (drd.Read())
                {
                    obEvaluacionPersona = new EEvaluacionPersona();
                    obEvaluacionPersona.i_id = drd["i_id"].ToString();
                    obEvaluacionPersona.v_dni = drd["v_dni"].ToString();
                    obEvaluacionPersona.v_nombre = drd["v_nombre"].ToString();
                    obEvaluacionPersona.i_anhio = drd["i_anhio"].ToString();
                    obEvaluacionPersona.v_area = drd["v_area"].ToString();
                    obEvaluacionPersona.v_cargo = drd["v_cargo"].ToString();
                    obEvaluacionPersona.v_tipo_cargo = drd["v_tipo_cargo"].ToString();
                    obEvaluacionPersona.v_zona_pais = drd["v_zona_pais"].ToString();
                    obEvaluacionPersona.v_sede = drd["v_sede"].ToString();
                    obEvaluacionPersona.v_jefe = drd["v_jefe"].ToString();
                    obEvaluacionPersona.v_btn1 = drd["v_btn1"].ToString();
                    obEvaluacionPersona.v_btn1Nombre = drd["v_btn1Nombre"].ToString();
                    obEvaluacionPersona.v_btn1Style = drd["v_btn1Style"].ToString();
                    obEvaluacionPersona.v_btn1Imagen = drd["v_btn1Imagen"].ToString();
                    obEvaluacionPersona.v_btn1Color = drd["v_btn1Color"].ToString();
                    obEvaluacionPersona.v_url = drd["v_url"].ToString();

                    lEvaluacionPersona.Add(obEvaluacionPersona);
                }
                drd.Close();
            }

            return (lEvaluacionPersona);
        }


        public List<EEvaluacionPersonaPdf> ListadoEvaluacionPdf_h(SqlConnection con, String v_dni , Int32 i_anhio)
        {
            List<EEvaluacionPersonaPdf> lEvaluacionPersonaPdf = null;
            SqlCommand cmd = new SqlCommand("usp_MostrarPdf_H", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@v_dni", SqlDbType.VarChar);
            par1.Direction = ParameterDirection.Input;
            par1.Value = v_dni;


            SqlParameter par2 = cmd.Parameters.Add("@i_anhio", SqlDbType.Int);
            par2.Direction = ParameterDirection.Input;
            par2.Value = i_anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEvaluacionPersonaPdf = new List<EEvaluacionPersonaPdf>();

                EEvaluacionPersonaPdf obEvaluacionPersonaPdf = null;
                while (drd.Read())
                {
                    obEvaluacionPersonaPdf = new EEvaluacionPersonaPdf();
                    obEvaluacionPersonaPdf.i_id = drd["i_id"].ToString();
                    obEvaluacionPersonaPdf.v_nombre = drd["v_nombre"].ToString();
                    obEvaluacionPersonaPdf.v_gerencia = drd["v_gerencia"].ToString();
                    obEvaluacionPersonaPdf.v_area = drd["v_area"].ToString();
                    obEvaluacionPersonaPdf.v_cargo = drd["v_cargo"].ToString();
                    obEvaluacionPersonaPdf.v_tipo_cargo = drd["v_tipo_cargo"].ToString();
                    obEvaluacionPersonaPdf.v_fingreso = drd["v_fingreso"].ToString();
                    obEvaluacionPersonaPdf.v_zona_pais = drd["v_zona_pais"].ToString();
                    obEvaluacionPersonaPdf.v_sede = drd["v_sede"].ToString();
                    obEvaluacionPersonaPdf.v_jefe = drd["v_jefe"].ToString();
                    obEvaluacionPersonaPdf.v_cuadro_ajuste = drd["v_cuadro_ajuste"].ToString();
                    obEvaluacionPersonaPdf.f_pt_final = drd["f_pt_final"].ToString();
                    obEvaluacionPersonaPdf.f_c1_inova_creatividad = drd["f_c1_inova_creatividad"].ToString();
                    obEvaluacionPersonaPdf.f_c2_impacto_influencia = drd["f_c2_impacto_influencia"].ToString();
                    obEvaluacionPersonaPdf.f_c3_pensamiento_estrategico = drd["f_c3_pensamiento_estrategico"].ToString();
                    obEvaluacionPersonaPdf.f_c4_excelecia = drd["f_c4_excelecia"].ToString();
                    obEvaluacionPersonaPdf.f_c5_pasiion = drd["f_c5_pasiion"].ToString();
                    obEvaluacionPersonaPdf.f_c6_orgullo = drd["f_c6_orgullo"].ToString();
                    obEvaluacionPersonaPdf.f_c7_compromiso = drd["f_c7_compromiso"].ToString();
                    obEvaluacionPersonaPdf.f_pt_final_01 = drd["f_pt_final_01"].ToString();
                    obEvaluacionPersonaPdf.f_esp_inova_creatividad = drd["f_esp_inova_creatividad"].ToString();
                    obEvaluacionPersonaPdf.f_esp_impact_influencia = drd["f_esp_impact_influencia"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pensamiento_estra = drd["f_esp_pensamiento_estra"].ToString();
                    obEvaluacionPersonaPdf.f_esp_excelencia = drd["f_esp_excelencia"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pasion = drd["f_esp_pasion"].ToString();
                    obEvaluacionPersonaPdf.f_esp_orgullo = drd["f_esp_orgullo"].ToString();
                    obEvaluacionPersonaPdf.f_esp_compromiso = drd["f_esp_compromiso"].ToString();
                    obEvaluacionPersonaPdf.f_suma = drd["f_suma"].ToString();

                    obEvaluacionPersonaPdf.f_esp_inova_creatividad_1 = drd["f_esp_inova_creatividad_1"].ToString();
                    obEvaluacionPersonaPdf.f_esp_impact_influencia_1 = drd["f_esp_impact_influencia_1"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pensamiento_estra_1 = drd["f_esp_pensamiento_estra_1"].ToString();
                    obEvaluacionPersonaPdf.f_esp_excelencia_1 = drd["f_esp_excelencia_1"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pasion_1 = drd["f_esp_pasion_1"].ToString();
                    obEvaluacionPersonaPdf.f_esp_orgullo_1 = drd["f_esp_orgullo_1"].ToString();
                    obEvaluacionPersonaPdf.f_esp_compromiso_1 = drd["f_esp_compromiso_1"].ToString();
                    obEvaluacionPersonaPdf.f_suma1 = drd["f_suma1"].ToString();

                    obEvaluacionPersonaPdf.f_esp_inova_creatividad_2 = drd["f_esp_inova_creatividad_2"].ToString();
                    obEvaluacionPersonaPdf.f_esp_impact_influencia_2 = drd["f_esp_impact_influencia_2"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pensamiento_estra_2 = drd["f_esp_pensamiento_estra_2"].ToString();
                    obEvaluacionPersonaPdf.f_esp_excelencia_2 = drd["f_esp_excelencia_2"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pasion_2 = drd["f_esp_pasion_2"].ToString();
                    obEvaluacionPersonaPdf.f_esp_orgullo_2 = drd["f_esp_orgullo_2"].ToString();
                    obEvaluacionPersonaPdf.f_esp_compromiso_2 = drd["f_esp_compromiso_2"].ToString();
                    obEvaluacionPersonaPdf.f_suma2 = drd["f_suma2"].ToString();

                    obEvaluacionPersonaPdf.f_esp_inova_creatividad_3 = drd["f_esp_inova_creatividad_3"].ToString();
                    obEvaluacionPersonaPdf.f_esp_impact_influencia_3 = drd["f_esp_impact_influencia_3"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pensamiento_estra_3 = drd["f_esp_pensamiento_estra_3"].ToString();
                    obEvaluacionPersonaPdf.f_esp_excelencia_3 = drd["f_esp_excelencia_3"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pasion_3 = drd["f_esp_pasion_3"].ToString();
                    obEvaluacionPersonaPdf.f_esp_orgullo_3 = drd["f_esp_orgullo_3"].ToString();
                    obEvaluacionPersonaPdf.f_esp_compromiso_3 = drd["f_esp_compromiso_3"].ToString();
                    obEvaluacionPersonaPdf.f_suma3 = drd["f_suma3"].ToString();

                    obEvaluacionPersonaPdf.f_esp_inova_creatividad_4 = drd["f_esp_inova_creatividad_4"].ToString();
                    obEvaluacionPersonaPdf.f_esp_impact_influencia_4 = drd["f_esp_impact_influencia_4"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pensamiento_estra_4 = drd["f_esp_pensamiento_estra_4"].ToString();
                    obEvaluacionPersonaPdf.f_esp_excelencia_4 = drd["f_esp_excelencia_4"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pasion_4 = drd["f_esp_pasion_4"].ToString();
                    obEvaluacionPersonaPdf.f_esp_orgullo_4 = drd["f_esp_orgullo_4"].ToString();
                    obEvaluacionPersonaPdf.f_esp_compromiso_4 = drd["f_esp_compromiso_4"].ToString();
                    obEvaluacionPersonaPdf.f_suma4 = drd["f_suma4"].ToString();

                    obEvaluacionPersonaPdf.f_esp_inova_creatividad_5 = drd["f_esp_inova_creatividad_5"].ToString();
                    obEvaluacionPersonaPdf.f_esp_impact_influencia_5 = drd["f_esp_impact_influencia_5"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pensamiento_estra_5 = drd["f_esp_pensamiento_estra_5"].ToString();
                    obEvaluacionPersonaPdf.f_esp_excelencia_5 = drd["f_esp_excelencia_5"].ToString();
                    obEvaluacionPersonaPdf.f_esp_pasion_5 = drd["f_esp_pasion_5"].ToString();
                    obEvaluacionPersonaPdf.f_esp_orgullo_5 = drd["f_esp_orgullo_5"].ToString();
                    obEvaluacionPersonaPdf.f_esp_compromiso_5 = drd["f_esp_compromiso_5"].ToString();
                    obEvaluacionPersonaPdf.f_suma5 = drd["f_suma5"].ToString();

                    lEvaluacionPersonaPdf.Add(obEvaluacionPersonaPdf);
                }
                drd.Close();
            }

            return (lEvaluacionPersonaPdf);
        }
    }
}
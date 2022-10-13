using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VEvaluacionPersona : BDconexion
    {
        public List<EEvaluacionPersona> ListadoEvaluacion(String dni)
        {
            List<EEvaluacionPersona> lEvaluacionPersona = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CEvaluacionPersona oVEvaluacionPersona = new CEvaluacionPersona();
                    lEvaluacionPersona = oVEvaluacionPersona.ListadoEvaluacion(con, dni);
                }
                catch (SqlException)
                {

                }
            }
            return (lEvaluacionPersona);
        }


        public List<EEvaluacionPersonaPdf> ListadoEvaluacionPdf(String v_dni , Int32 i_anhio)
        {
            List<EEvaluacionPersonaPdf> lEvaluacionPersona = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CEvaluacionPersona oVEvaluacionPersona = new CEvaluacionPersona();
                    lEvaluacionPersona = oVEvaluacionPersona.ListadoEvaluacionPdf_h(con, v_dni, i_anhio);
                }
                catch (SqlException)
                {

                }
            }
            return (lEvaluacionPersona);
        }

    }
}
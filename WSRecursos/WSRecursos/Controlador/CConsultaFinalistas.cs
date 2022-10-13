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
    public class CConsultaFinalistas
    {
        public List<EConsultaFinalistas> ConsultaFinalistas(SqlConnection con)
        {
            List<EConsultaFinalistas> lEConsultaFinalistas = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTA_FINALISTA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConsultaFinalistas = new List<EConsultaFinalistas>();

                EConsultaFinalistas obEConsultaFinalistas = null;
                while (drd.Read())
                {
                    obEConsultaFinalistas = new EConsultaFinalistas();
                    obEConsultaFinalistas.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEConsultaFinalistas.v_publicacion = drd["v_publicacion"].ToString();
                    obEConsultaFinalistas.v_puesto = drd["v_puesto"].ToString();
                    obEConsultaFinalistas.v_dni = drd["v_dni"].ToString();
                    obEConsultaFinalistas.v_nombres = drd["v_nombres"].ToString();
                    obEConsultaFinalistas.v_celular = drd["v_celular"].ToString();
                    obEConsultaFinalistas.v_correo = drd["v_correo"].ToString();
                    obEConsultaFinalistas.i_hijos = Convert.ToInt32(drd["i_hijos"].ToString());
                    obEConsultaFinalistas.i_status = Convert.ToInt32(drd["i_status"].ToString());
                    obEConsultaFinalistas.v_estado = drd["v_estado"].ToString();
                    obEConsultaFinalistas.v_color_estado = drd["v_color_estado"].ToString();
                    lEConsultaFinalistas.Add(obEConsultaFinalistas);
                }
                drd.Close();
            }

            return (lEConsultaFinalistas);
        }
    }
}
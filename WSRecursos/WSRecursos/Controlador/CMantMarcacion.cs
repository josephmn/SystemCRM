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
    public class CMantMarcacion
    {
        public List<EMantenimiento> MantMarcacion(SqlConnection con, String dni, String comentario, Int32 marcahuella, Int32 marcadni, String temperatura, String remoto)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASISTENCIA_Z_MARCACION_X_DNI", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@COMENTARIO", SqlDbType.VarChar).Value = comentario;
            cmd.Parameters.AddWithValue("@MARCAHUELLA", SqlDbType.Int).Value = marcahuella;
            cmd.Parameters.AddWithValue("@MARCADNI", SqlDbType.Int).Value = marcadni;
            cmd.Parameters.AddWithValue("@TEMPERATURA", SqlDbType.VarChar).Value = temperatura;
            cmd.Parameters.AddWithValue("@REMOTO", SqlDbType.VarChar).Value = remoto;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEMantenimiento = new List<EMantenimiento>();

                EMantenimiento obEMantenimiento = null;
                while (drd.Read())
                {
                    obEMantenimiento = new EMantenimiento();
                    obEMantenimiento.v_icon = drd["v_icon"].ToString();
                    obEMantenimiento.v_title = drd["v_title"].ToString();
                    obEMantenimiento.v_text = drd["v_text"].ToString();
                    obEMantenimiento.i_timer = Convert.ToInt32(drd["i_timer"].ToString());
                    obEMantenimiento.i_case = Convert.ToInt32(drd["i_case"].ToString());
                    obEMantenimiento.v_progressbar = Convert.ToBoolean(drd["v_progressbar"].ToString());
                    lEMantenimiento.Add(obEMantenimiento);
                }
                drd.Close();
            }

            return (lEMantenimiento);
        }
    }
}
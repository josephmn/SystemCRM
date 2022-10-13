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
    public class CMantArchivosLegajo
    {
        public List<EMantenimiento> MantArchivosLegajo(SqlConnection con,
            Int32 post,
            Int32 id,
            String nombre,
            String carpeta,
            String modulo,
            Int32 estado,
            Int32 cantidad,
            String tipoarchivo,
            String tamanio,
            String dni)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_ARCHIVO_LEGAJO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@nombre", SqlDbType.VarChar).Value = nombre;
            cmd.Parameters.AddWithValue("@carpeta", SqlDbType.VarChar).Value = carpeta;
            cmd.Parameters.AddWithValue("@modulo", SqlDbType.VarChar).Value = modulo;
            cmd.Parameters.AddWithValue("@estado", SqlDbType.Int).Value = estado;
            cmd.Parameters.AddWithValue("@cantidad", SqlDbType.Int).Value = cantidad;
            cmd.Parameters.AddWithValue("@tipoarchivo", SqlDbType.VarChar).Value = tipoarchivo;
            cmd.Parameters.AddWithValue("@tamanio", SqlDbType.VarChar).Value = tamanio;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

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
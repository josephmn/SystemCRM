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
    public class CMantPerfilPersonal
    {
        public List<EMantenimiento> MantPerfilPersonal(SqlConnection con, String dni, String nombre, String fnacimiento,
            Int32 civil, String celular, String correo, String correoempresa, String celularsos, String nombresos,
            String departamento, String provincia, String distrito, String domicilioactual, String referencia, String user)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_INSERT_PERFIL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@nombre", SqlDbType.VarChar).Value = nombre;
            cmd.Parameters.AddWithValue("@fnacimiento", SqlDbType.VarChar).Value = fnacimiento;
            cmd.Parameters.AddWithValue("@civil", SqlDbType.Int).Value = civil;
            cmd.Parameters.AddWithValue("@celular", SqlDbType.VarChar).Value = celular;
            cmd.Parameters.AddWithValue("@correo", SqlDbType.VarChar).Value = correo;
            cmd.Parameters.AddWithValue("@correoempresa", SqlDbType.VarChar).Value = correoempresa;
            cmd.Parameters.AddWithValue("@celular_sos", SqlDbType.VarChar).Value = celularsos;
            cmd.Parameters.AddWithValue("@nombre_sos", SqlDbType.VarChar).Value = nombresos;
            cmd.Parameters.AddWithValue("@departamento", SqlDbType.VarChar).Value = departamento;
            cmd.Parameters.AddWithValue("@provincia", SqlDbType.VarChar).Value = provincia;
            cmd.Parameters.AddWithValue("@distrito", SqlDbType.VarChar).Value = distrito;
            cmd.Parameters.AddWithValue("@domicilio_actual", SqlDbType.VarChar).Value = domicilioactual;
            cmd.Parameters.AddWithValue("@referencia", SqlDbType.VarChar).Value = referencia;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;

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